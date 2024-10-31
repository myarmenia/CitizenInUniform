<?php

namespace App\DTO;
use Illuminate\Http\Request;

class FaqCategorySubcategoryDto
{
    public function __construct(
        public string $title,
        public int $f_a_q_category_id,
        public  string $content,

    )
    {}
    public static  function fromRequestDto(Request $request): FaqCategorySubcategoryDto {
        return  new self(
            title: $request->title,
            f_a_q_category_id: $request->f_a_q_category_id,
            content:$request->content
        );
    }
    public function toArray()
    {
        return [
            'title' => $this->title,
            'f_a_q_category_id' => $this->f_a_q_category_id,
            'content'=> $this->content
        ];
    }



}



?>
