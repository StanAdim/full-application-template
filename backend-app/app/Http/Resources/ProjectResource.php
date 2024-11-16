<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'category' => $this->category,
            'year' => $this->year,
            'brief' => $this->brief,
            'status' => $this->verify,
            'registrationDate'=> Carbon::parse($this->created_at)->format('M j, Y, H:i'),

        ];
    }
}
