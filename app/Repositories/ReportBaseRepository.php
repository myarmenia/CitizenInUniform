<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
class ReportBaseRepository
{

    protected function report($data, Model $model): int
    {

        $query = $model->query();

        $governing_body_id = MyHelper::getAuthUserGoverningBodyId();


        if ($governing_body_id) {
            $data->governing_body_id = $governing_body_id;

        }
        // else {
        //     $user = Auth::user();

        //     if ($user->hasRole('super_admin')) {

        //         if (isset($this->data->governing_id)) {
        //             $query->where('governing_body_id', $data->governing_id);
        //         }
        //     }
        // }


        $query = $query->filter($data)->get()->count();

        return $query;

    }


}
