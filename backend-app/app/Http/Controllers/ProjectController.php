<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectCategoryResource;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Exports\ProjectExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function index(Request $request){
        $user_id = Auth::id();
           $projects = ProjectResource::collection(Project::where('user_id', $user_id)->get());
            return response()->json([
                'message' => 'All Projects',
                'data' => $projects
            ],200);
        // } else {
        //     return response()->json([
        //         'message' => 'User Projects',
        //         'data' => ProjectResource::collection($user->projects)
        //     ],200);
        // }
    }
    public function guestViewProjects (){
        $projects = ProjectResource::collection(Project::all());
            return response()->json([
                'message' => 'All Projects',
                'data' => $projects
            ],200);
    }
    public function getProject($uuid)
    {
        if (true) {
        $project = Project::where('id',$uuid)->first();
        if ($project) {
            return response()->json([
                 'message' => 'Project',
                 'data' => $project
             ],200);

        } else {
            return response()->json([
                'message' => 'No such Project',
            ],404);
        }
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
        $id = Auth::id();
       $validatedData = $request->validate([
            'title' => ['required','min:3', 'max:255'],
            'year' => ['required','max:255'],
            'brief' => ['required', 'max:255'],
            'category' => ['required']
         ]);
        $validatedData = $validatedData + ['user_id' => $id];
        $project = Project::create($validatedData);
        return response()->json([
            'data' => $project,
            'message' => 'Project Detailed Stored',
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

    public function projectUpdate($UUID , Request $request){
        $accessPermissions = ["can_edit_project"];
        if (true) {
        $proje = Project::where('id', $UUID)->first();
                $validator = Validator::make($request->all(),
                [
                    'title' => ['max:255'],
                    'year' => [ 'max:255'],
                    'brief' => [ 'min:25'],
                    'requiredSupport' => ['max:255'],
                    'comment' => ['max:255'],
                    'verify' => ['boolean'],
                    'isNominated' => ['boolean'],
                    'category' => ['array']
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
           else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
      }

        public function projectDelete($UUID){
            $accessPermissions = ["can_delete_project"];
            // $user = $request->user();
            if (true) {

                $project = Project::findOrFail($UUID);

             $project->delete();

             return response()->json([
                'message' => 'Project Deleted!',
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'No Access',
            ],200);
           }
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
