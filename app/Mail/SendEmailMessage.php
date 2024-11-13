<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailMessage extends Mailable
{
    use Queueable, SerializesModels;
    public $messageContent;
    public $subject;
    public $email;


    /**
     * Create a new message instance.
     */
    public function __construct($messageContent, $subject, $email)
    {
        $this->messageContent = $messageContent;
        $this->subject = $subject;
        $this->email = $email;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send-email-message',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function build()
    {
        $mail = $this->with([
            'messageContent' => $this->messageContent,
        ])->to($this->email);


        return $mail;
    }
}
