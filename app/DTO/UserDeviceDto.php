<?php

namespace App\DTO;
use Illuminate\Http\Request;

class UserDeviceDto
{

    public function __construct(
        public string $device_id,
        public string $type

    ) {
    }

    public static function fromUserDeviceDto(Request $request): UserDeviceDto
    {
        return new self(
            device_id: $request->device_id,
            type: $request->type
        );
    }

    public function toArray()
    {
        return [
            'device_id' => $this->device_id,
            'type' => $this->type

        ];
    }


}
