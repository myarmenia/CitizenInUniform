<?php

namespace App\Services;


use App\Interfaces\CategoryInterface;
use App\Interfaces\ReportInterface;
use Illuminate\Http\Request;
use Storage;

class ReportService
{
    public function __construct(
        protected ReportInterface $reportRepository
    ) {
    }

    public function report($data)
    {

        $messageCount = ' - ';
        $chatCount = ' - ';
        $callCount = ' - ';
        $downloadAppCount = ' - ';
        $downloadAppIos = ' - ';
        $downloadAppAndroid = ' - ';


        if (!empty($data->message_type) && $data->message_type == 'email') {
            $messageCount = $this->emailMessages($data);
        }
        else if (!empty($data->message_type) && $data->message_type == 'chat') {
            $chatCount = $this->chatMessages($data);
        }
        else {

            if (!empty($data->message_category_id)) {
                $messageCount = $this->emailMessages($data);
                $chatCount = $this->chatMessages($data);
            }

            if (empty($data->message_category_id) && !empty($data->governing_body_id)) {
                $messageCount = $this->emailMessages($data);
                $chatCount = $this->chatMessages($data);
                $callCount = $this->phoneCalls($data);
            }

            if (empty($data->message_type) && empty($data->governing_body_id) && empty($data->message_category_id)) {
                $messageCount = $this->emailMessages($data);
                $chatCount = $this->chatMessages($data);
                $callCount = $this->phoneCalls($data);
                $downloadAppCount = $this->downloadApp($data);
                $downloadAppIos = $this->downloadAppIos($data);
                $downloadAppAndroid = $this->downloadAppAndroid($data);

            }

        }



        $result = [
            'message_count' => $messageCount,
            'chat_count' => $chatCount,
            'call_count' => $callCount,
            'all_download_count' => $downloadAppCount,
            'ios_download_count' => $downloadAppIos,
            'android_download_count' => $downloadAppAndroid,


        ];

        return $result;
    }


    public function emailMessages($data)
    {

        return $this->reportRepository->emailMessage($data);

    }

    public function chatMessages($data)
    {
        return $this->reportRepository->chatMessage($data);

    }

    public function phoneCalls($data)
    {
        return $this->reportRepository->phoneCall($data);

    }

    public function downloadApp($data)
    {
        return $this->reportRepository->downloadApp($data);

    }
    public function downloadAppIos($data)
    {
        $data->type = 'ios';
        return $this->reportRepository->downloadApp($data);

    }
    public function downloadAppAndroid($data)
    {
        $data->type = 'android';
        return $this->reportRepository->downloadApp($data);

    }



}
