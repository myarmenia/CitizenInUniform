<?php

namespace App\DTO;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryDto
{

    public function __construct(
        public string $title,
        public ?UploadedFile $file = null,
        public ?string $path = null


    ) {
    }

    public static function fromCategoryDto(Request $request): CategoryDto
    {
        return new self(
            title: $request->title,
            file: $request->file,
            path: $request->path ?? null

        );
    }

    public function toArray()
    {
        return array_filter([
        'title' => $this->title,
        'path' => $this->path,
    ], function ($value) {
        return $value !== null;
    });
    }


}
