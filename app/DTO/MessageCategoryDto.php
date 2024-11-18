<?php

namespace App\DTO;
use Illuminate\Http\Request;

class MessageCategoryDto
{
    public function __construct(
        public string $title,
    )
    {}
    public static  function fromMessageCategoryDto(Request $request): MessageCategoryDto {
        return  new self(
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



?>
