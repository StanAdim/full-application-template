<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrassrootProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        return [
            'type' => 'Grassroot Program',
            'uid' => $this->uid,
            'name' => $this->grassroot_name,
            'focusArea' => $this->focus_area,
            'status' => $this->status,
            'description' => $this->brief_description,
           ];
    }
}
