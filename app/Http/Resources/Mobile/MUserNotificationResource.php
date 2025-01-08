<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MUserNotificationResource extends JsonResource
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
            "setting_id" => $this->setting_id,
            "mobile_user_id" => $this->mobile_user_id,
            "title" => $this->setting->name ?? null,
            "content" => $this->setting_id != 4 ?
                        ($this->title && $this->content ?  $this->title . " - " . $this->content :
                        ($this->title ? $this->title :
                        ($this->content ?? null)))  : ($this->content ?? null),
            "created_at" => $this->created_at

        ];
    }
}
