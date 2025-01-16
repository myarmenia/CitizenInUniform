<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class EmailMessageFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "email_messages_id"=>$this->email_messages_id,
            "path"=>url('') . Storage::url($this->path),
            "name"=>$this->name,
        ];
    }
}
