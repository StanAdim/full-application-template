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
            'phone' => $this->phone_number,
            'email' => $this->email,
            'rank' => $this->rank,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'roles' => $this->roles,
            // Add any other fields you want to include
        ];
    }
}
