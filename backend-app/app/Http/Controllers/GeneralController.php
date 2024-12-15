<?php

namespace App\Http\Controllers;

use App\Models\Categories\AcceleratorProfile;
use App\Models\Categories\GrassrootProgramProfile;
use App\Models\Categories\HubProfile;
use App\Models\Categories\StartupProfile;
use App\Models\DocumentType;
use App\Models\FundingStage;
use App\Models\ICTSector;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralController extends Controller
{
    public function profileCount($type) : JsonResponse{
        $Items = match ($type) {
            'startups' => StartupProfile::all()->count(),
            "hubs" => HubProfile::all()->count(),
            "accelerators" => AcceleratorProfile::all()->count(),
            "grassroots" => GrassrootProgramProfile::all()->count(),
            default => 0,
        };
        return response()->json([
            'message' => 'Success!, '.$type.' count',
            'count' => $Items
        ],200);
   }
   public function sectors () : JsonResponse{
            $items = ICTSector::all()->map(function ($sector) {
                return [
                    'value' => $sector->id,
                    'label' => $sector->name,
                ];
            });
            return response()->json([
            'message' => 'Sectors',
            'data' => $items
        ],200);
   }   public function document_types (): JsonResponse {
            $items = DocumentType::all()->map(function ($type) {
                return [
                    'value' => $type->id,
                    'label' => $type->name,
                ];
            });
            return response()->json([
            'message' => 'types',
            'data' => $items
        ],200);
   }
   public function fundingStages (): JsonResponse{
            $items = FundingStage::all()->map(function ($sector) {
                return [
                    'value' => $sector->id,
                    'label' => $sector->name,
                    'description' => $sector->description,
                ];
            });
            return response()->json([
            'message' => 'Funding stages',
            'data' => $items
        ],200);
   }
   public function getRegions () : JsonResponse{
            $items = Region::all()->map(function ($sector) {
                return [
                    'value' => $sector->id,
                    'label' => $sector->region,
                ];
            });
            return response()->json([
            'message' => 'Regions',
            'data' => $items
        ],200);
   }
}
