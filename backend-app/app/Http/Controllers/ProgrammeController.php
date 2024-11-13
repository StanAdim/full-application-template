<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgrammeResource;
use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgrammeController extends Controller
{
    public function index(Request $request){
        $accessPermissions = ["can_view_all_programmes"];
        $user = $request->user();
        if ($this->hasUserAccess($accessPermissions)) {#permission checking
            $programmes = ProgrammeResource::collection(Programme::all());
            return response()->json([
                'message' => 'All Programmes',
                'data' => $programmes
            ],200);
        }
        else {
            return response()->json([
                'message' => 'User Programmes',
                'data' => $user->programmes
            ],200);
        }
    }
    public function getProgramme($uuid)
    {
        $accessPermissions = ["can_view_programme"];
        if ($this->hasUserAccess($accessPermissions)) {
        $programme = Programme::where('id',$uuid)->first();
        if ($programme) {
            return response()->json([
                 'message' => 'Programme Success',
                 'data' => $programme
             ],200);

        } else {
            return response()->json([
                'message' => 'No such programme',
            ],404);
        }
    }
    else{
        return response()->json([
            'message' => 'No Access',
        ],202);
    }
   }


    public function store(Request $request){
        $accessPermissions = ['can_create_programme'];
            if ($this-> hasUserAccess($accessPermissions)){
                $validator = Validator::make($request->all(),[
                    'user_id' => ['required'],
                    'title' => ['required','min:3', 'max:255','string'],
                    'description' => ['required','min:3','string'],
                    'funding' => ['required','min:3'],
                    'owner' => ['required','min:3','string'],
                    'eligibility' => ['array'],
                    'applicantGroups' => ['array'],
                ]);
                #Failure response of Validation
                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Validation fails',
                        'errors' => $validator->errors()
                    ],422);
                }
                $data = $validator->validated();
                $newProgramme = Programme::create($data);
                return response()->json([
                    'message' => 'Programme Created Successful',
                    'data' => $newProgramme
                ],200);

            }
            else {
                return response()->json([
                    'message' => "Access Denied"
                ], 422);
            }
    }
    public function showProgramme($uuid){
        $accessPermissions = ["can_view_programme"];
        if ($this->hasUserAccess($accessPermissions)) {#permission checking
            $programme = Programme::where('id', $uuid)->first();
            return response()->json([
                'message' => 'Programme Fetch Success',
                'data' => $programme
            ],200);
        }
        else{
            return response()->json([
                'message' => 'Access Denied'
            ],422);
        }
    }
    public function update(Request $request, $uuid)
    {
        $programme = Programme::where('id', $uuid);
        $validator = Validator::make($request->all(),
        [
            'title' => ['required','min:3', 'max:255','string'],
                'description' => ['required','min:3','string'],
                'funding' => ['required','min:3'],
                'owner' => ['required','min:3','string'],
                'eligibility' => ['array'],
                'applicantGroups' => ['array'],
                
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


    public function destroy(Programme $programme)
    {
        $accessPermissions = ['can_delete_programme'];
        if($this->hasUserAccess($accessPermissions)){
            $save = $programme->delete();
            return response()->json([
                'data' => $save,
                'message' => 'Programme Deleted Successful',
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Access Denied',
            ], 422);
        }
    }
}
