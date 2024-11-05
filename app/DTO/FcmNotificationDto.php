<?php

namespace App\DTO;
use Illuminate\Http\Request;

class FcmNotificationDto
{

    public function __construct(
        public int $setting_id,
        public string $title,
        public ?string $content = null,

    ) {
    }

    public static function fromFcmNotificationDto(Request $request): FcmNotificationDto
    {
        return new self(
            setting_id: $request->setting_id,
            title: $request->title,
            content: $request->content

        );
    }

    public function toArray()
    {
        return [
            'setting_id' => $this->setting_id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }


}
