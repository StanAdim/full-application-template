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
    public function profilesOfType($type, Request $request)
    {
        // Define searchable models mapping
        $typeModels = [
            'startups' => [
                'model' => StartupProfile::class,
                'searchFields' => ['startup_name', 'industry', 'website', 'description']
            ],
            'hubs' => [
                'model' => HubProfile::class,
                'searchFields' => ['hub_name', 'available_programs', 'brief'] // Add actual searchable fields
            ],
            'accelerators' => [
                'model' => AcceleratorProfile::class,
                'searchFields' => ['accelerator_name', 'brief_description'] // Add actual searchable fields
            ],
            'grassroots' => [
                'model' => GrassrootProgramProfile::class,
                'searchFields' => ['grassroot_name', 'brief_description', 'focus_area'] // Add actual searchable fields
            ]
        ];
    
        // Validate type
        if (!isset($typeModels[$type])) {
            return response()->json([
                'message' => 'Invalid profile type',
                'data' => []
            ], 400);
        }
    
        // Get model and search fields for the type
        $modelConfig = $typeModels[$type];
        $modelClass = $modelConfig['model'];
        $searchFields = $modelConfig['searchFields'];
    
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
    
        // Transform results based on resource class
        $resourceClass = $this->getResourceClass($type);
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
    
    /**
     * Get the appropriate resource class for the profile type
     * 
     * @param string $type
     * @return string
     */
    private function getResourceClass($type)
    {
        $resourceMap = [
            'startups' => StartupResource::class,
            'hubs' => HubResource::class,
            'accelerators' => AcceleratorResource::class,
            'grassroots' => GrassrootProgramResource::class
        ];
    
        return $resourceMap[$type] ?? StartupResource::class; // default fallback
    }
}
