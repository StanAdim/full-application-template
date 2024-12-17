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
        // Collect all permissions from the user's roles
        $permissions = $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique()->values();

        return [
            'uid' => $this->uid,
            'name' => $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name,
            'phone' => $this->phone_number,
            'email' => $this->email,
            'rank' => $this->rank,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'roles' => $this->roles,
            'permissions' => $permissions,  // Add permissions here
        ];
    }
}
