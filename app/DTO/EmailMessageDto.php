<?php

namespace App\DTO;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EmailMessageDto
{

    public function __construct(
        public int|array $governing_body_id,
        public string $fullname,
        public string $email,
        public string $phone,
        public int $message_category_id,
        public string $content,
        public int $mobile_user_id

    ) {
    }

    public static function fromEmailMessageDto(Request $request): EmailMessageDto
    {
        return new self(
            governing_body_id: $request->governing_body_id,
            fullname: $request->fullname,
            email: $request->email,
            phone: $request->phone,
            message_category_id: $request->message_category_id,
            content: $request->content,
            mobile_user_id: $request->mobile_user_id

        );
    }

    public function toArray()
    {
        return [
            'governing_body_id' => $this->governing_body_id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'message_category_id' => $this->message_category_id,
            'content' => $this->content,
            'mobile_user_id' => $this->mobile_user_id

        ];
    }


}
