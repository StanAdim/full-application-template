<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->first_name. ' '. $this->middle_name. ' '. $this->last_name,
            'rank' => $this->rank,
            'roles' => $this->roles,
            // Add any other fields you want to include
        ];
    }
}
