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
    public $message;
    public $subject;
    public $email;
    public $mailer_name;



    /**
     * Create a new message instance.
     */
    public function __construct($message, $subject, $email, $mailer_name)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->email = $email;
        $this->mailer_name = $mailer_name;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject

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
            'data' => $this->message,
        ])->to($this->email);

        $mail->replyTo(env("MAIL_FROM_ADDRESS_$this->mailer_name"), 'Այս նամակին պատասխանելու համար օգտվեք հավելվածից։');

        return $mail;
    }
}
