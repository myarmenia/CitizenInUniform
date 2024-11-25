<?php

namespace App\Interfaces;

interface ReportInterface
{
    public function emailMessage($data);
    public function chatMessage($data);
    public function phoneCall($data);
    public function downloadApp($data);

}
