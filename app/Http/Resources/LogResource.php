<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            "user_name" => MyHelper::getGetUserName($this->user_id),
            "action" => $this->action,
            "details" => $this->details,
            "ip" => $this->ip,
            "roles" => join(', ', array_map(fn($role) => __("roles.{$role}"), json_decode($this->roles))),
            "date" => date('d-m-Y H:i', strtotime($this->created_at))
        ];
    }
}
