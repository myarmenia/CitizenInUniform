<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\SubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllCategoriesResource extends JsonResource
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
            "sub_categories" => SubCategoryResource::collection($this->sub_categories)

        ];
    }
}
