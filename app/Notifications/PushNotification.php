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


        // $notification = \App\Models\Notification::create([
        //     'setting_id' => null, // Укажите значение или сделайте поле nullable
        //     'mobile_user_id' => $notifiable->id,
        //     'title' => $this->title,
        //     'content' => $this->content,
        //     'read_at' => null, // Уведомление еще не прочитано
        // ]);
$notifiable['fcm_token'] = 'eWPj6UzmQvOVj6pPZBpKUu:APA91bEBWYExqdcD3nrxoNMDXcOIMGvalqD2f1RYd8zoCSJpdIxQr7fLiKmtrNgjL4TmoxbRIjycdgqtRvKFT_HhCCE_1MviGhOW40plOtWyf5AQuR2xSd0';
        // FcmNotificationService::storeNotification();
        Log::info("successfuly -----    $notifiable");
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


        Log::info(print_r($message));
        return $message;

    }

}
