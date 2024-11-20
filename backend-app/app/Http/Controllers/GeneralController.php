<?php

namespace App\Http\Controllers;

use App\Models\Categories\AcceleratorProfile;
use App\Models\Categories\GrassrootProgramProfile;
use App\Models\Categories\HubProfile;
use App\Models\Categories\StartupProfile;
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
   }}
