<?php

namespace App\DTO;
use Illuminate\Http\Request;

class FcmNotificationDto
{

    public function __construct(
        public int $setting_id,
        public ?int $mobile_user_id = null,
        public ?string $title,
        public ?string $content = null,
        public ?string $key = null

    ) {
    }

    public static function fromFcmNotificationDto(Request $request): FcmNotificationDto
    {
        return new self(
            setting_id: $request->setting_id,
            mobile_user_id: $request->mobile_user_id ?? null,
            title: $request->title,
            content: $request->content,
            key: $request->key ?? null,

        );
    }

    public function toArray()
    {
        return [
            'setting_id' => $this->setting_id,
            'mobile_user_id' => $this->mobile_user_id,
            'title' => $this->title,
            'content' => $this->content,
            'key' => $this->key

        ];
    }


}
