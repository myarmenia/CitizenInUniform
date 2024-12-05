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

    private $sound;
    // private $setting_name;

    private $data;

    /**
     * Create a new notification instance.
     */


    public function __construct($data)
    {

        $this->title = $data->title;
        $this->content = $data->content;
        $this->sound = $data->sound;

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

        $message = FcmMessage::create()
                    ->notification(
                        FcmNotification::create()
                            ->title($this->title)
                            ->body($this->content)
                    )
                    ->data([
                            'title' => $this->title,
                            'content' => $this->content,
                            // 'setting_name' => $this->setting_name
                        ]
                    )
                     ->android([
                            'sound' => $this->sound  // Android sound option /custom_sound.mp3
                        ]
                    )
                    ->apns([
                            'sound' => $this->sound  // iOS sound option
                        ]
                    );


        // Log::channel('notify')->info('Notification error for user ' . "FCM message created: " . print_r($message, true));

        return $message;

    }

}
