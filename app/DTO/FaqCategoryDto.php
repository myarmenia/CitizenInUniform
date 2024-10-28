<?php

namespace App\DTO;
use Illuminate\Http\Request;

class FaqCategoryDto
{
    public function __construct(
        public string $title,
    )
    {}
    public static  function fromFaqCategoryDto(Request $request): FaqCategoryDto {
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
