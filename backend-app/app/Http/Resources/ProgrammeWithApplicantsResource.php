<?php

namespace App\Http\Resources;

use App\Models\ProgrammeApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgrammeWithApplicantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return   [
        'title' => $this->title,
        'uid' => $this->id,
        'user' => (new UserResource($this->user))->name,
        'description' => $this->description,
        'funding' => $this->funding,
        'owner' => $this->owner,
        'closing_date' => Carbon::parse($this->closing_date)->format('j M, Y'),
        'eligibility' => $this->eligibility,
        'status' => $this->status,
        'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
        'applications' => ApplicantsResource::collection(ProgrammeApplication::where('programme_id', $this->id)->get()),

    ];
    }
}
