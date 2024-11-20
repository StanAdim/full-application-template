<?php

namespace App\Http\Resources;

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
        'industry' => $this->industry,
        'status' => $this->status,
        'fundingStage' => $this->funding_stage,
        'teamSize' => $this->team_size,
        'website' => $this->website,
        'website' => $this->website,
        'uid' => $this->uid,
        'name' => $this->startup_name,
        'description' => $this->description,
        'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),

       ];

    }
}
