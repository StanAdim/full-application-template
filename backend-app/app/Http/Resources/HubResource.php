<?php

namespace App\Http\Resources;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'Innovation Hub',
            'uid' => $this->uid,
            'name' => $this->hub_name,
            'totalMembers' => $this->total_members, // Include startup-specific data
            'femaleNumber' => $this->number_female,
            'membershipOption' => $this->membership_option,
            'availablePrograms' => $this->available_programs,
            'status' => $this->status,
            'partnerships' => $this->partnerships,
            'description' => $this->brief,
            'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
                    // Profileable data

            'phone' => $this->profile->phone_number,
            'email' => $this->profile->email,
            'region' => Region::where('id', $this->profile->region)->first()->region,
            'logoPath' => $this->profile->logo_path,
            'establishmentDate' => Carbon::parse($this->profile->date_establishment)->format('j M, Y'),

           ];
    }
}
