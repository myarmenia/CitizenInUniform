<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
class ReportBaseRepository
{

    protected function report($data, Model $model): int
    {
        
        $query = $model->query();

        if (isset($this->data->governing_id)) {
            $query->where('governing_body_id', $data->governing_id);
        }

        $query = $query->filter($data)->get()->count();

        return $query;

    }


}
