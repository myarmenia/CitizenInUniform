<?php

namespace App\Observers;

use App\Helpers\MyHelper;
use App\Models\Log;
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
        $user = Auth::user();
        $tb_name = $model->getTable();
        $roles = $user ? json_encode($user->roles->pluck('name')) : null;

        $governing_body_id = MyHelper::getAuthUserGoverningBodyId();


        if ($action == 'deleted') {
            $details = $model->getOriginal();
        } else {
            $details = $model->getDirty();
            $details['id'] = $model->id;

        }

        // if (isset($details['content']) && ($tb_name == 'email_message_answers' || $tb_name == 'messages')) {
        //     unset($details['content']);
        // }

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
