<?php

namespace App\Observers;

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
        
        $roles = $user ? json_encode($user->roles->pluck('name')) : null;

        $originalAttributes = $model->getOriginal();
        $changedAttributes = $model->getDirty();


        if(isset($model->password)){
             unset($changedAttributes['password']);
        }

        $details = [
            'old' => array_intersect_key($originalAttributes, $changedAttributes),
            'new' => $changedAttributes,
            'id' => $model->id
        ];


        Log::create([
            'user_id' => $user ? $user->id : null,
            'roles' => $roles,
            'tb_name' => $model->getTable(),
            'action' => $action,
            'details' => json_encode($details),  //getDirty,   getAttributes
            'ip' => request()->ip(),
        ]);
    }
}
