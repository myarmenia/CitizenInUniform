<?php

namespace App\DTO;

use Google\Cloud\Core\Timestamp;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LogDto
{
    public $data;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function fromReportDto($data): LogDto
    {
        return new self($data);
    }


    public function toArray()
    {
        return [
            'action' => $this->action ?? null,
            'role' => $this->role ?? null,
            'tb_name' => $this->tb_name ?? null,
            'from_created_at' => $this->from_created_at ?? null,
            'to_created_at' => $this->to_created_at ?? null
        ];
    }


}
