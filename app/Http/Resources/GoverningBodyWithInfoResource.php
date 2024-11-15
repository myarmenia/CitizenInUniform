<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class GoverningBodyWithInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "name" => $this->name,
            "path" => url('') . Storage::url($this->path),
            "infos" => $this->governing_body_infos,
            "email" => $this->email,
            "phone" => $this->phone
        ];
    }
}
