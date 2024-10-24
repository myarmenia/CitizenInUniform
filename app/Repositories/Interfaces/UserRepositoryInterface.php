<?php
namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function store(array $data): User;
    public function findByEmail(string $email): ?User;
}
