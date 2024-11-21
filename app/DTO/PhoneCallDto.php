<?php

namespace App\DTO;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhoneCallDto
{

    public function __construct(
        public int $mobile_user_id,
        public int $governing_body_id,
        public string $phone_number

    ) {
    }

    public static function fromPhoneCallDto(Request $request): PhoneCallDto
    {
        return new self(
            mobile_user_id: $request->mobile_user_id,
            governing_body_id: $request->governing_body_id,
            phone_number: $request->phone_number

        );
    }

    public function toArray()
    {
        return [
            'mobile_user_id' => $this->mobile_user_id,
            'governing_body_id' => $this->governing_body_id,
            'phone_number' => $this->phone_number

        ];
    }


}
