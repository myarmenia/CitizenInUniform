<?php

namespace App\Http\Resources;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailSingleMessageResource extends JsonResource
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
            "phone"=> $this->phone,
            "msg_category" => ['deleted' => $this->message_category_withTrashed->deleted_at,
                                    'title' => $this->message_category_withTrashed->title
                                ],
            "date" => date('d-m-Y H:i', strtotime($this->created_at)),
            "content" => MyHelper::decryptData($this->content),
            "answers" => EmailMessageAnswerResource::collection($this->answers),
            "files"=>EmailMessageFileResource::collection($this->email_messages_files)
        ];
    }
}
