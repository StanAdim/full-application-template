<?php

namespace App\Http\Controllers;

use App\Http\Resources\AcceleratorResource;
use App\Http\Resources\GrassrootProgramResource;
use App\Http\Resources\HubResource;
use App\Http\Resources\StartupResource;
use App\Models\Categories\AcceleratorProfile;
use App\Models\Categories\GrassrootProgramProfile;
use App\Models\Categories\HubProfile;
use App\Models\Categories\StartupProfile;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{

    // Global types
    protected $typeModels = [
       'startups' => [
                'model' => StartupProfile::class,
                'resource' => StartupResource::class,
                'searchFields' => ['startup_name', 'industry', 'website', 'description']
            ],
            'hubs' => [
                'model' => HubProfile::class,
                'resource' => HubResource::class,
                'searchFields' => ['hub_name', 'available_programs', 'brief'] // Add actual searchable fields
            ],
            'accelerators' => [
                'model' => AcceleratorProfile::class,
                'resource' => AcceleratorResource::class,

                'searchFields' => ['accelerator_name', 'brief_description'] // Add actual searchable fields
            ],
            'grassroots' => [
                'model' => GrassrootProgramProfile::class,
                'resource' => GrassrootProgramResource::class,
                'searchFields' => ['grassroot_name', 'brief_description', 'focus_area'] // Add actual searchable fields
            ]
    ];

    /**
     * Get profile configuration for a specific type
     */
    protected function getProfileConfig($type){
        return $this->typeModels[$type] ?? null;
    }

    public function profilesOfType($type, Request $request){
        // Validate type
        $profileConfig = $this->getProfileConfig($type);
        if (!$profileConfig) {
            return response()->json([
                'message' => 'Invalid profile type',
                'data' => []
            ], 400);
        }

        // Extract configuration
        $modelClass = $profileConfig['model'];
        $resourceClass = $profileConfig['resource'];
        $searchFields = $profileConfig['searchFields'];

        // Retrieve query parameters
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        // Build query
        $query = $modelClass::query()->orderBy('id', 'desc');

        // Apply search if search term exists
        if ($search) {
            $query->where(function ($q) use ($search, $searchFields) {
                foreach ($searchFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        // Paginate results
        $items = $query->paginate($perPage);

        // Transform results
        $data = $resourceClass::collection($items);

        // Return paginated response
        return response()->json([
            'message' => "Success! All {$type}",
            'data' => $data,
            'pagination' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'next_page_url' => $items->nextPageUrl(),
                'prev_page_url' => $items->previousPageUrl(),
            ],
        ], 200);
    }

    public function singleDetails($type, $uid){
        // Validate type
        $profileConfig = $this->getProfileConfig($type);
        if (!$profileConfig) {
            return response()->json([
                'message' => 'Invalid profile type',
                'data' => []
            ], 400);
        }
    
        // Extract configuration
        $modelClass = $profileConfig['model'];
        $resourceClass = $profileConfig['resource'];
    
        // Find the specific profile
        $profile = $modelClass::where('uid', $uid)->first();
    
        // Check if profile exists
        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'data' => null
            ], 404);
        }
    
        // Use resource for a single item, not collection
        $data = new $resourceClass($profile);
    
        return response()->json([
            'data' => $data,
            'message' => 'Data found',
        ], 200);
    }

    public function changeApprovalStatus($type, $uid){
        // Validate type
        $profileConfig = $this->getProfileConfig($type);
        if (!$profileConfig) {
            return response()->json([
                'message' => 'Invalid profile type',
                'data' => []
            ], 400);
        }
        // Extract configuration
        $modelClass = $profileConfig['model'];
        // Find the specific profile
        $profile = $modelClass::where('uid', $uid)->first();
        // Check if profile exists
        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'data' => null
            ], 404);
        }
        // Update status
        $modelClass::where('id', $profile->id)->update(['status' => !$profile->status]);
        return response()->json([
            'message' => 'Status updated successfully',
        ], 200);
    }
     /**
     * Get available profile types
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfileTypes(){
        return response()->json([
            'message' => 'Available profile types',
            'types' => array_keys($this->typeModels)
        ]);
    }
    /**
     * Add a new profile type dynamically (if needed)
     * 
     * @param string $type
     * @param array $config
     */
    public function addProfileType($type, array $config){
        $this->typeModels[$type] = $config;
    }
}
