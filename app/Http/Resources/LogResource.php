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

        $details = $this->details;

        if ( $this->tb_name == 'email_message_answers' || $this->tb_name == 'messages') {
            $details = json_decode($details, true);
            $details['content'] = MyHelper::decryptData($details['content']);
            $details = json_encode($details);
        }

        return [
            "id" => $this->id,
            "user_name" => $user_name,
            "action" => __("actions.$this->action"),
            "details" => $details,
            "tb_name" => __("tbnames.$this->tb_name"),
            "ip" => $this->ip,
            "roles" => $roles,
            "date" => date('d-m-Y H:i', strtotime($this->created_at))
        ];
    }
}
