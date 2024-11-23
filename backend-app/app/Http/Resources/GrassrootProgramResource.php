<?php

namespace App\Http\Resources;

use App\Models\ICTSector;
use App\Models\Region;
use Carbon\Carbon;
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
            'focusArea' => $this->getFocusAreaNames(),
            'status' => $this->status,
            'description' => $this->brief_description,
            'registrationDate'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
                    // Profileable data

            'phone' => $this->profile->phone_number,
            'email' => $this->profile->email,
            'region' => Region::where('id', $this->profile->region)->first()->region,
            'logoPath' => $this->profile->logo_path,
            'establishmentDate' => Carbon::parse($this->profile->date_establishment)->format('j M, Y'),


           ];
    }
    /**
     * Get focus area names based on focus area IDs.
     *
     * @return array<string>
     */
    protected function getFocusAreaNames(): array
    {
        $focusAreaIds = is_array($this->focus_area) ? $this->focus_area : json_decode($this->focus_area, true);

        return ICTSector::whereIn('id', $focusAreaIds)->pluck('name')->toArray();
    }
}
