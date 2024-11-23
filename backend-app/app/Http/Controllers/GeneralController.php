<?php

namespace App\Http\Controllers;

use App\Models\Categories\AcceleratorProfile;
use App\Models\Categories\GrassrootProgramProfile;
use App\Models\Categories\HubProfile;
use App\Models\Categories\StartupProfile;
use App\Models\FundingStage;
use App\Models\ICTSector;
use App\Models\Region;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function profileCount($type){
        switch ($type) {
            case 'startups':
                $Items = StartupProfile::all()->count();
                break;
            case "hubs":
                $Items = HubProfile::all()->count();
                break;
            case "accelerators":
                $Items = AcceleratorProfile::all()->count();
                break;
            case "grassroots":
                $Items = GrassrootProgramProfile::all()->count();
                break;
            default:
            $Items = 0;
        }
        return response()->json([
            'message' => 'Success!, '.$type.' count',
            'count' => $Items
        ],200);
   }
   public function sectors (){
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
   }
   public function fundingStages (){
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
   public function getRegions (){
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
