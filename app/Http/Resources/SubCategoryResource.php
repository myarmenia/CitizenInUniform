<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "category_id" => $this->category_id,
            "title" => $this->tile,
            "content" => $this->content,
            "type" => $this->type,
            "files" => SubCategoryFilesResource::collection($this->files)
        ];
    }
}
