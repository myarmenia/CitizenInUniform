<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqCategorySubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id"=>$this->id,
            "f_a_q_category_id"=>$this->f_a_q_category_id ?? null,
            "f_a_q_category_name"=>$this->f_a_q_category->title ?? null,
            "title"=>$this->title ?? null,
            "content"=>$this->content  ?? null
        ];
    }
}
