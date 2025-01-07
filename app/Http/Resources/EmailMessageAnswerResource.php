<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailMessageAnswerResource extends JsonResource
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
            "content" => $this->content,
            "user_name" => $this->user_withTrashed->name . ' ' . $this->user_withTrashed->surname,
            "date" => date('d-m-Y H:i', strtotime($this->created_at))
        ];
    }
}
