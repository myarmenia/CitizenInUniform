<?php

namespace App\Observers;

use App\Helpers\MyHelper;
use App\Models\Log;
use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Model;

class BaseModelObserver
{
    public function created(Model $model)
    {
        $this->logAction($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logAction($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logAction($model, 'deleted');
    }

    protected function logAction(Model $model, string $action)
    {

        $tb_name = $model->getTable();

        if($tb_name == 'messages'){
            $operator_id = $model->writer == 'operator' ? $model->writer_id : null;
            $user = $operator_id ? User::find( $operator_id) : null;

            $governing_body_id = $user ? $user->governing_body_user->governing_body_id : null;

        }
        else{
            $user = Auth::user();

            $governing_body_id = MyHelper::getAuthUserGoverningBodyId();
        }

        $roles = $user ? json_encode($user->roles->pluck('name')) : null;


        if ($action == 'deleted') {
            $details = $model->getOriginal();
        } else {
            $details = $model->getDirty();
            $details['id'] = $model->id;

        }

        
        if(isset($model->password)){
             unset($details['password']);
        }

        if (array_key_exists('path', $details) && $details['path'] == null) {

            unset($details['path']);
        }

        $details = json_encode($details);


        Log::create([
            'user_id' => $user ? $user->id : null,
            'governing_body_id' => $governing_body_id,
            'roles' => $roles,
            'tb_name' => $model->getTable(),
            'action' => $action,
            'details' => $details,  //getDirty
            'ip' => request()->ip(),
        ]);
    }
}
