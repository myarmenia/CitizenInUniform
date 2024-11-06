<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            "title" => $this->title,
            "content" => $this->content,
            "setting" => new SettingResource($this->setting),
            "created_at" => date('d-m-Y', strtotime($this->created_at))
        ];
    }
}
