<?php

namespace App\DTO;

use Google\Cloud\Core\Timestamp;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReportDto
{
    public $data;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function fromReportDto($data): ReportDto
    {
        return new self($data);
    }


    public function toArray()
    {
        return [
            'message_category_id' => $this->message_category_id ?? null,
            'message_type' => $this->message_type ?? null,
            'governing_body_id' => $this->governing_body_id ?? null,
            'from_created_at' => $this->from_created_at ?? null,
            'to_created_at' => $this->to_created_at ?? null
        ];
    }


}
