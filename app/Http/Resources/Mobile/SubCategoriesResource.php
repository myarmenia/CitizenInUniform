<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "category_id" => $this->category_id,
            "title" => $this->title,
            "content" => $this->content,
            "type" => $this->type,
            "sub_categories" => SubCategoryResource::collection($this->sub_categories)

        ];
    }
}
