<?php

namespace App\Http\Resources;

use App\Models\DocumentType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'name' => $this->file_name,
            'uid' => $this->uid,
            'type' => DocumentType::where('id', $this->document_type_id)->first()->name,
            'path' => $this->path,
            'registration_date'=> Carbon::parse($this->created_at)->format('j M, Y, H:i'),
            'status' => $this->status ? 1 : 0,
        ];
    }
}
