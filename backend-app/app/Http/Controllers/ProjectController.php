<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectCategoryResource;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Exports\ProjectExport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default items per page is 12
        // Build the query for fetching users
        $user_id = Auth::id();
        $user = User::find($user_id);
    
        if ($user->hasRole('admin')) {
            $query = Project::orderBy('id', 'desc'); // Remove ->get() to keep it as a query builder
        } else {
            $query = Project::where('user_id', $user_id)->orderBy('id', 'desc');
        }
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('year', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('brief', 'like', "%{$search}%");
                // Add other fields for search if needed
            });
        }
        // Paginate the results
        $items = $query->paginate($perPage);
        if ($items->isNotEmpty()) {
            return response()->json([
                'message' => "Registered projects",
                'data' => ProjectResource::collection($items),
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'last_page' => $items->lastPage(),
                    'per_page' => $items->perPage(),
                    'total' => $items->total(),
                    'next_page_url' => $items->nextPageUrl(),
                    'prev_page_url' => $items->previousPageUrl(),
                ],
                'code' => 200,
            ]);
        }
        return response()->json([
            'message' => "No project found",
            'data' => [],
            'code' => 300,
        ]);
    }
    public function guestViewProjects (){
        $projects = ProjectResource::collection(Project::all());
            return response()->json([
                'message' => 'All Projects',
                'data' => $projects
            ],200);
    }
    public function count(){
        $user_id = Auth::id();
        $user = User::find($user_id);
        if ($user->hasRole('admin')) {
            $Items = Project::all();
        }else{
            $Items = Project::where('user_id', $user_id)->get();
        }
        if ($Items) {
            return response()->json([
                'message' => 'Projects count',
                'count' => $Items->count()
            ],200);
        } 
   }
    public function getProject($uid){
        $project = Project::where('uid',$uid)->first();
        if ($project->exists) {
            return response()->json([
                 'message' => 'Project',
                 'data' => $project
             ],200);
        } 
   }

    public function get_categories(){
        $category = ProjectCategoryResource::collection(ProjectCategory::all());
        return response()->json([
            'message' => 'Project Categories',
            'data' => $category
        ],200);
       }

    public function projectStore(Request $request){
        $user= Auth::user();
        $profile_id = $user->profile->id;
        $validatedData = $request->validate([
            'title' => ['required','min:3', 'max:255'],
            'year' => ['required','max:255'],
            'brief' => ['required', 'max:255'],
            'category' => ['required']
         ]);
        $validatedData = $validatedData + ['user_id' => $user->id,'profile_id' => $profile_id];
        $project = Project::create($validatedData);
        return response()->json([
            'data' => $project,
            'message' => 'New Project registered',
        ], 200);
   }

    public function storeComment($uuid, Request $request){
       $accessPermissions = ["can_create_comment"];
       if (true) {
        $validatedData = Validator::make($request->all(), [
            'comment' =>  ['nullable','min:3', 'max:255'],
        ]);

        $validatedData->validate();
        if($validatedData->valid()){
            $project = Project::where('id', $uuid)->first();
            $comment = $project->update($validatedData->validated());
        }
        return response()->json([
           'data' => $comment,
           'message' => 'Comment Stored',
        ], 200);
      }
    else {
        return response()->json([
            'message' => 'No Access',
        ],200);
    }
   }

    public function verifyProject(Request $request, Project $project)
    {
        $accessPermissions = ["can_verify_project"];
        if (true) {
            $project->update([
                "verify" => !$project->verify ? true : false
            ]);
            return response()->json([
                'data' => $project,
                'message' => 'Project Verified',
                ], 200);
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
        }
    }

    public function projectUpdate(Request $request){
        $proje = Project::where('uid', $request->input('uid'))->first();
                $validator = Validator::make($request->all(),[
                    'title' => ['max:255'],
                    'year' => [ 'max:255'],
                    'brief' => [ 'min:25'],
                    // 'requiredSupport' => ['max:255'],
                    // 'comment' => ['max:255'],
                    // 'verify' => ['boolean'],
                    // 'isNominated' => ['boolean'],
                    'category' => ['']
                ]);

                $validator->validate();
                if($validator->valid()){
                    $save = $proje->update($validator->validated());
                }
                return response()->json([
                    'data' => $save,
                    'message' => 'Project Updated!',
                ], 200);
         
      }

        public function projectDelete($UUID){
            $project = Project::where('uid',$UUID)->first();
            $project->delete();
             return response()->json([
                'message' => 'Project Deleted!',
            ], 200);
        }

        public function projectExport() 
        {
        $accessPermissions = ["can_view_all_projects"];
        // $user = $request->user();
        if (true) {
            // return Excel::download(new ProjectExport, 'Projects.xlsx');
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
        }
}
