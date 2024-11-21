<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcceleratorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'type' => 'Digital Accelerator',
            'uid' => $this->uid,
            'name' => $this->accelerator_name,
            'focusArea' => $this->focus_area,
            'status' => $this->status,
            'description' => $this->brief_description,
            'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),

           ];
    }
}
