<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class SystemUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'uid'=> $this->uid,
            'email'=> $this->email,
            'phone'=> $this->phone_number,
            'rank'=> $this->rank,
            'name'=> $this->first_name.' '. $this->middle_name. ' '. $this->last_name,
            // 'roles'=> $this->roles,
            'isVerified'=> $this->email_verified_at? 1: 0,
            'registrationDate'=> Carbon::parse($this->created_at)->format('M j, Y, H:i'),
            'last_login'=> Carbon::parse($this->last_login)->format('M j, Y, H:i'),
        ];  
    }
}
