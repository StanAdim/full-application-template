<?php

namespace App\Http\Resources;

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
           ];
    }
}
