<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ExceptionReport extends Mailable
{
    use SerializesModels;

    protected $message;

    protected $file;

    protected $line;

    protected $code;

    protected $trace;

    protected $user;

    public function __construct(Throwable $exception, $user = null)
    {
        //        $this->exception = $exception;

        // Extract and store the exception details as strings
        $this->message = $exception->getMessage();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->code = $exception->getCode();
        $this->trace = $exception->getTraceAsString();
        $this->user = $user;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 Exception: '.get_class($this->exception),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.exception',
            with: [
                'name' => get_class($this->exception),
                'msg' => $this->exception->getMessage(),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
                'url' => request()->fullUrl(),
                'trace' => $this->exception->getTraceAsString(),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
