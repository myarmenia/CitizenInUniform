<?php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotifyService
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory())
            ->withServiceAccount(config('firebase.credentials'))
            ->createMessaging();
    }

    public function sendNotification(string $deviceToken, string $title, string $body, array $data = [])
    {
        $notification = Notification::create($title, $body);
        // $notification = ['title' => $title, 'body' => $body];


        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        try {
            $this->messaging->send($message);
            return ['success' => true, 'message' => 'Notification sent'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
