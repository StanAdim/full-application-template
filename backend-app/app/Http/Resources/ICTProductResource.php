<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ICTProductResource extends JsonResource
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
            'name' => $this->name,
            'is_launched' => $this->is_launched,
            'category' => $this->category,
            'launched_date' => Carbon::parse($this->launched_date)->format('j M, Y'),
            'brief' => $this->brief,
            'status' => $this->verify,
            'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
        ];
    }
}
