<?php

namespace App\Http\Resources;

use App\Models\FundingStage;
use App\Models\ICTSector;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StartupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'type' => 'ICT Startup',
        'founders' => $this->founders, // Include startup-specific data
        'industry' => ICTSector::where('id',$this->industry)->first()->name,
        'status' => $this->status,
        'fundingStage' => FundingStage::where('id',$this->funding_stage)->first()->name,
        'teamSize' => $this->team_size,
        'website' => $this->website,
        'website' => $this->website,
        'uid' => $this->uid,
        'name' => $this->startup_name,

        // Profileable data

        'phone' => $this->profile->phone_number,
        'email' => $this->profile->email,
        'region' => Region::where('id', $this->profile->region)->first()->region,
        'logoPath' => $this->profile->logo_path,
        'establishmentDate' => Carbon::parse($this->profile->date_establishment)->format('j M, Y'),

        'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
        'description' => $this->description,
       ];

    }
}
