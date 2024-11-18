<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class MGoverningBodyResource extends JsonResource
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
            "named" => $this->named,
             "email" => $this->email,
            "phone" => $this->phone,
            "phone_numbers" => $this->governing_body_phone_numbers->where('status',1)->pluck('text'),
        ];
    }
}
