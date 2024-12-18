<?php

namespace App\Http\Resources;

use App\Models\Categories\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'profile' => (new ProfileResource(Profile::where('uid', $this->profile_id)->first())),
            'status' => $this->status,
            'applied_on'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
        ];
    }
}
