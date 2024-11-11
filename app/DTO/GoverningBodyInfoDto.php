<?php

namespace App\DTO;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoverningBodyInfoDto
{

    public function __construct(
        public int $governing_body_id,
        public string $type,
        public array $data

    ) {
    }

    public static function fromGoverningBodyDto(Request $request): GoverningBodyInfoDto
    {
        return new self(
            governing_body_id: $request->governing_body_id,
            type: $request->type,
            data: $request->data

        );
    }

    public function toArray()
    {
        return [
            'governing_body_id' => $this->governing_body_id,
            'type' => $this->type,
            'data' => $this->data
        ];
    }


}
