<?php

namespace App\DTO;
use App\Http\Requests\Api\EntryCodeRequest;
use Illuminate\Http\Request;


class EntryCodeDto
{

    public function __construct(
        public readonly string $token,
        public readonly string $type,
        public readonly string $mac,
        public int $user_id = 0

    ) {
    }

    // public static function fromAppRequest(AppBlogRequest $request): EntryCodeDto
    // {
    //     return new self(
    //         title: $request->validated('title'),
    //         body: $request->validated('body'),
    //         source: BlogSource::App
    //     );
    // }


    public static function fromApiRequest(Request $request): EntryCodeDto
    {
        return new self(
            token: $request->token,
            type: $request->type,
            mac: $request->mac
        );
    }

    public function toArray()
    {
        return [
            'user_id' => $this->user_id,
            'type' => $this->type,
            'token' => $this->token
        ];
    }
}
