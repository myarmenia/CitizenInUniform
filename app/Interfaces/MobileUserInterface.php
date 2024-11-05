<?php

namespace App\Interfaces;

interface MobileUserInterface
{
    public function getAll();
    public function store($data);
    public function getAllMobileUsersWithActiveSettings();

}
