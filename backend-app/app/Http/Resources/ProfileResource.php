<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        // Base profile attributes
        $data = [
            'uid' => $this->uid,
            'status' => $this->status,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'region' => $this->region,
            'date_establishment' => $this->date_establishment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Customize the response based on the `profileable` type
        if ($this->profileable_type === 'App\Models\StartupProfile') {
            $data['profileable'] = [
                'type' => 'ICT Startup',
                'founders' => $this->profileable->founders, // Include startup-specific data
                'industry' => $this->profileable->industry,
                'funding_stage' => $this->profileable->funding_stage,
            ];
        } elseif ($this->profileable_type === 'App\Models\HubProfile') {
            $data['profileable'] = [
                'type' => 'Innovation Hub',
                'facilities' => $this->profileable->facilities,
                'programs_offered' => $this->profileable->programs_offered,
            ];
        } elseif ($this->profileable_type === 'App\Models\AcceleratorProfile') {
            $data['profileable'] = [
                'type' => 'Digital Accelerator Accelerator',
                'cohort_size' => $this->profileable->cohort_size,
                'duration' => $this->profileable->duration,
            ];
        } else {
            // Default data if the type is not specific to the startup ecosystem
            $data['profileable'] = [
                'type' => $this->profileable_type,
                'data' => $this->profileable,
            ];
        }

        return $data;
    }
}
