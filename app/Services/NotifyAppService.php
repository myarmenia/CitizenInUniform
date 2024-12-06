<?php
namespace App\Services;

// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\RegistrationToken;
// use Kreait\Firebase\Messaging\Notification;
// use Kreait\Firebase\Exception\Messaging\SendException;
// use Log;
// use Kreait\Firebase\Factory;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Log;
use App\Models\MobileUser;

class NotifyAppService
{


    public static function sendNotification()
    {
        $mobileUsers = MobileUser::all();
        foreach ($mobileUsers as $user) {

            try {

                if (!$user->fcm_token) {
                    throw new \Exception('FCM token is missing');
                }


                // ==============================================
                $deviceToken = $user->fcm_token;

                $notification = Notification::create('aaaaaa', 'bbbbb');
                $message = CloudMessage::withTarget('token', $deviceToken)
                    ->withNotification($notification);


                Firebase::messaging()->send($message);
                Log::info("FCM message created: " . print_r($message, true));

            } catch (\Exception $e) {
                \Log::channel('notify')->error('Notification error for user ' . $user->id . ': ' . $e->getMessage());
            }
        }


    }

}
