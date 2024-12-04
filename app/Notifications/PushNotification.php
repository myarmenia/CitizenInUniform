<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Log;
class PushNotification extends Notification
{
    use Queueable;

    private $title;
    private $content;
    // private $setting_name;

    private $data;

    /**
     * Create a new notification instance.
     */
    // public function __construct($title, $content)
    // {

    //     $this->title = $title;
    //     $this->content = $content;
    // }

    public function __construct($data)
    {

        $this->title = $data->title;
        $this->content = $data->content;
        // $this->setting_name = $data->setting_name;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        return [FcmChannel::class];

    }

    /**
     * Get the mail representation of the notification.
     */


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */


    public function toFcm($notifiable): FcmMessage
    {

        // $notifiable['fcm_token'] = 'f9QOSx3lSwOv2XpxwW0iTo:APA91bE4Lg66byiaA-SP6CQYIcdB9vnuJJuS-kR-FL1GyNoR78kQY5WDwLNY8eexNQm6xh0GI191TDqnP4AhhD8PMbgyvXyUi-LQc2Uj6TFpePmoSLWwtfI';
        // FcmNotificationService::storeNotification();


        // Log::info("successfuly -----    $notifiable");
        $message = FcmMessage::create()
                    ->notification(
                        FcmNotification::create()
                            ->title($this->title)
                            ->body($this->content)
                    )
                    ->data([
                        'fcm_token' => (string) $notifiable->fcm_token,
                        'title' => $this->title,
                        'content' => $this->content,
                        // 'setting_name' => $this->setting_name
                    ]);


        Log::info("FCM message created: " . print_r($message, true));

        return $message;

        // $fcmToken = $notifiable->fcm_token;
        // $fcmToken = 'f9QOSx3lSwOv2XpxwW0iTo:APA91bE4Lg66byiaA-SP6CQYIcdB9vnuJJuS-kR-FL1GyNoR78kQY5WDwLNY8eexNQm6xh0GI191TDqnP4AhhD8PMbgyvXyUi-LQc2Uj6TFpePmoSLWwtfI';


        // $message = FcmMessage::create()
        //     ->notification(
        //         FcmNotification::create()
        //             ->title($this->title)
        //             ->body($this->content)
        //     )
        //     ->data([
        //         // 'fcm_token' => (string) $notifiable->fcm_token,
        //         'fcm_token' => (string) $fcmToken,

        //         'title' => $this->title,
        //         'content' => $this->content,
        //     ]);

        // // Логирование отправленного сообщения
        // Log::info("FCM message created: " . print_r($message, true));

        // return $message;

    }

}
