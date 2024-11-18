<?php

namespace App\DTO;
use Illuminate\Http\Request;

class MessageCategoryDto
{

    public function __construct(

        public string $title,
       

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
