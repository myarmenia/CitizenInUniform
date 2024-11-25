<?php

namespace App\Repositories;

use App\Helpers\MyHelper;
use App\Interfaces\ReportInterface;
use App\Models\EmailMessages;
use App\Models\Message;
use App\Models\MobileUser;
use App\Models\PhoneCall;
use App\Models\Room;
use Auth;


class ReportRepository extends ReportBaseRepository implements ReportInterface
{

    public function emailMessage($data): int
    {
        $model = new EmailMessages();

        return $this->report($data, $model);
    }

    public function chatMessage($data): int
    {
        $model = new Room();

        return $this->report($data, $model);

    }

    public function phoneCall($data): int
    {

        $model = new PhoneCall();

        return $this->report($data, $model);
    }

    public function downloadApp($data): int
    {
        $model = new MobileUser();
        return $this->report($data, $model);
    }



}
