<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        // Base profile attributes
        $data = [
            'uid' => $this->uid,
            'status' => $this->status,
            'phone' => $this->phone_number,
            'email' => $this->email,
            'region' => $this->region,
            'logoPath' => $this->logo_path,
            'establishmentDate' =>  $this->date_establishment,
            'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
        ];

        // Customize the response based on the `profileable` type
        if ($this->profileable_type === 'App\Models\Categories\StartupProfile') {
            $data['profileable'] = new StartupResource($this->profileable);
        } 
        elseif ($this->profileable_type === 'App\Models\Categories\HubProfile') {
            $data['profileable'] = new HubResource($this->profileable);
        } 
        elseif ($this->profileable_type === 'App\Models\Categories\AcceleratorProfile') {
            $data['profileable'] = new AcceleratorResource($this->profileable);
        } 
        elseif ($this->profileable_type === 'App\Models\Categories\GrassrootProgramProfile') {
            $data['profileable'] = new GrassrootProgramResource($this->profileable);
        } 
        else {
            // Default data if the type is not specific to the startup ecosystem
            $data['profileable'] = [
                'type' => $this->profileable_type,
                'data' => $this->profileable,
            ];
        }
        return $data;
    }
}
