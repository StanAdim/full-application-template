<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgrammeResource;
use App\Models\Programme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgrammeController extends Controller
{
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default items per page is 12
        // Build the query for fetching users
        $user_id = Auth::id();
        $user = User::find($user_id);

        if ($user->hasRole('admin')) {
            $query = Programme::orderBy('id', 'desc'); // Remove ->get() to keep it as a query builder
        } else {
            if($user->hasRole('promotor')) {
                $query = Programme::where('user_id', $user_id)->orderBy('id', 'desc');
            }else{
                $query = Programme::where('status', true)->orderBy('id', 'desc'); // Remove ->get() to keep it as a query builder
            }
        }
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('owner', 'like', "%{$search}%")
                    ->orWhere('eligibility', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        // Paginate the results
        $items = $query->paginate($perPage);
        if ($items->isNotEmpty()) {
            return response()->json([
                'message' => "Registered projects",
                'data' => ProgrammeResource::collection($items),
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
            'message' => "No programmes found",
            'data' => [],
            'code' => 300,
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
        'title' => ['required','min:3', 'max:255','string'],
        'description' => ['required','min:3','string'],
        'funding' => ['required','integer','min:0'],
        'eligibility' => ['array'],
        'closing_date' => ['required','date'],
        'owner' => ['required','min:3','string'],
//       'applicantGroups' => ['array'],
        ]);
        #Failure response of Validation
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'errors' => $validator->errors()
            ],422);
        }
        $user_id = Auth::id();$data = $validator->validated();
        $data = array_merge($data, ['user_id' => $user_id]);
        $newProgramme = Programme::create($data);
        return response()->json([
            'message' => 'Programme Created Successful',
            'data' => $newProgramme
        ],200);
    }
    public function show($uid){
        $product = Programme::where('id',$uid)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Programme not found!',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => new ProgrammeResource($product),
        ]);
    }
    public function update(Request $request, $uuid){
        $programme = Programme::where('id', $uuid);
        $validator = Validator::make($request->all(), [
            'title' => ['required','min:3', 'max:255','string'],
            'description' => ['required','min:3','string'],
            'funding' => ['required','min:3'],
            'owner' => ['required','min:3','string'],
            'closing_date' => ['required','date'],
            'eligibility' => ['array'],
//          'applicantGroups' => ['array'],
        ]);
        $accessPermissions = ["can_view_programme"];
        if ($this->hasUserAccess($accessPermissions)) {#permission checking
             #Failure response of Validation
         if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'errors' => $validator->errors()
            ],422);

        }
        $save = $programme->update($validator->validated());
        $programme->refresh();
        return response()->json([
            'data' => $programme,
            'message' => 'Details Update Successful',
        ], 200);
        }
        else{
            return response()->json([
                'message' => "Access Denied"
            ], 422);
        }
    }
    public function approve(Request $request){
        $item = Programme::where( 'id', $request->uid)->first();
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Programme  not found!',
            ], 404);
        }
        $item->status = !$item->status ;
        $item->save();
        return response()->json([
            'success' => true,
            'message' => 'Programme Approved successfully!',
        ]);
    }
    public function destroy($uid){
        $item = Programme::where( 'id', $uid)->first();
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Programme  not found!',
            ], 404);
        }
        $item->delete();
        return response()->json([
            'success' => true,
            'message' => 'Programme deleted successfully!',
        ]);
    }
}
