<?php

namespace App\Interfaces;

interface FcmNotificationInterface
{
    public function index();
    public function store($data);

}
