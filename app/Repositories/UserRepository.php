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
$user='';

        $authUser = Auth::user();
        $query = User::query();

        if ($authUser->hasRole('super_admin') ) {

            $query->where('id', '!=', $authUser->id)->get();
        } else {

            $users = User::all();
        }
        return $query->get();

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

