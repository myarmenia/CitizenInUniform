<?php
namespace App\Services;

use App\Models\PersonPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChangeStatusService
{
    public static function change_status($request){

        $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);

        $className = 'App\Models\\' . Str::studly(Str::singular($request->tb_name));
      

        $model = '';

        if(class_exists($className)) {
            $model = new $className;
        }


        if(!is_string($model)){
            $item = $model->where('id', $request->id)->first();

            $update = $item->update([$request->field_name => $status]);

            return $update;
        }

    }

}
