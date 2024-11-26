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
        $roles = $this->roles != null ? join(', ', array_map(fn($role) => __("roles.{$role}"), json_decode($this->roles))) : ' - - - ';
        $user_name = MyHelper::getGetUserName($this->user_id) ?? ' - - - ';

        return [
            "id" => $this->id,
            "user_name" => $user_name,
            "action" => __("actions.$this->action"),
            "details" => $this->details,
            "tb_name" => __("tbnames.$this->tb_name"),
            "ip" => $this->ip,
            "roles" => $roles,
            "date" => date('d-m-Y H:i', strtotime($this->created_at))
        ];
    }
}
