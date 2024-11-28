<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ip'=>$this->ip,
            'date'=>Carbon::parse($this->date)->format('d.m.Y H:i:s'),
            'status'=>$this->status,
            'email'=>$this->email
        ];

    }
}
