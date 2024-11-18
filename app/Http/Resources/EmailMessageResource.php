<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailMessageResource extends JsonResource
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
            "fullname" => $this->fullname,
            "email" => $this->email,
            "msg_category_name" => $this->message_category_withTrashed->title,
            "date" => date('d-m-Y H:i', strtotime($this->created_at))
        ];
    }
}
