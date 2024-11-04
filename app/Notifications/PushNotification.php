<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class PushNotification extends Notification
{
    use Queueable;

    private $title;
    private $content;
    private $mobile_user_id;


    /**
     * Create a new notification instance.
     */
    public function __construct($mobile_user_id, $title, $content)
    {

        $this->mobile_user_id = $mobile_user_id;
        $this->title = $title;
        $this->content = $content;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public function toFcm($notifiable)
    {


        $notification = \App\Models\Notification::create([
            'setting_id' => null, // Укажите значение или сделайте поле nullable
            'mobile_user_id' => $notifiable->id,
            'title' => $this->title,
            'content' => $this->content,
            'read_at' => null, // Уведомление еще не прочитано
        ]);

         $p = FcmMessage::create()
            ->setData([
                'id' => $notification->id, // Используйте id уведомления для отслеживания
                'title' => $this->title,
                'content' => $this->content,
            ])
            ->setNotification([
                'title' => $this->title,
                'body' => $this->content,
                'sound' => 'default',  // Стандартный звук уведомления
            ]);
            dd($p);
            return $p;
    }
}
