<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Staff;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserRepository implements UserRepositoryInterface
{
    public function index(){

        $authUser = Auth::user();
        $query = User::query()
                ->where('users.id', '!=', $authUser->id);
                
        if ($authUser->hasRole('super_admin') ) {

            $query->whereHas('roles', function ($query) {
                $query->where('position_name', '=', 'super_admin');
            });
        }
        elseif($authUser->hasRole('admin')){

            $query->whereHas('roles', function ($query) {
                $query->where('position_name', '=', 'admin');
            });
        }
        return  $query->orderBy('id','desc')->get();

    }
    public function store(array $data): User
    {

        $user = User::create($data);

        $user->assignRole($data['roles']);

        return $user;

    }
    public function update($id, $data){

        $user=User::findOrFail($id);

        $user->update($data);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        // Поиск пользователя по email
        return User::where('email', $email)->first();
    }
}

