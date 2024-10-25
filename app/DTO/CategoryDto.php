<?php

namespace App\DTO;
use Illuminate\Http\Request;

class CategoryDto
{

    public function __construct(
        public string $title,
        // public ?bool $status = null,

    ) {
    }

    public static function fromCategoryDto(Request $request): CategoryDto
    {
        return new self(
            title: $request->title
        );
    }

    public function toArray()
    {
        return [
            'title' => $this->title

        ];
    }


}
