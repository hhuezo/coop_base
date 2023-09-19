<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AportacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $file;

    public function __construct($subject, $content, $file)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->file = $file;
    }

    public function build()
    {
        return $this->view('reportes.correo')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->subject)
            ->attach($this->file);
    }
    public function envelope()
    {
        return new Envelope(
            subject: 'Aportacion',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
