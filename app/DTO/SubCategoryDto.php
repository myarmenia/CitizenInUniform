<?php

namespace App\DTO;
use Illuminate\Http\Request;

class SubCategoryDto
{

    public function __construct(

        public string $category_id,
        public string $title,
        public string $content,
        public ?array $files = null

    ) {
    }

    public static function fromSubCategoryDto(Request $request): SubCategoryDto
    {

        return new self(
            category_id: $request->category_id,
            title: $request->title,
            content: $request->content,
            files: $request['files']

        );
    }

    public function toArray()
    {
        return [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }


}
