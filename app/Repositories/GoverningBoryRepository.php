<?php

namespace App\Repositories;

use App\Interfaces\GoverningBodyInterface;
use App\Models\Category;
use App\Models\GoverningBody;


class GoverningBoryRepository implements GoverningBodyInterface
{
    public function index()
    {
        return GoverningBody::all();
    }

    public function getItem(string $id)
    {
        return GoverningBody::find($id);
    }

    public function update($data, string $id)
    {

        $governing_body = $this->getItem($id);

        if($data['type'] == 'globalSettings'){

            $update = $governing_body->update($data['data']);
        }

        else if($data['type'] == 'email'){
            $data['text'] = $data['data']['text'];
            $data['status'] = $data['data']['status'];

            $update = $governing_body->governing_body_email()->updateOrCreate(['governing_body_id' => $id, 'type' => $data['type'] ], $data);
        }
        else{

            $governing_body->governing_body_phone_numbers()->delete();

            foreach ($data['data'] as $key => $value) {
                $data['text'] = $value['phone'];
                $data['status'] = $value['status'];

                $update = $governing_body->governing_body_phone_numbers()->create($data);
            }

        }

        return $update;
    }



}
