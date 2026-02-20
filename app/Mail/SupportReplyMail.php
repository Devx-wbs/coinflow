<?php

namespace App\Mail;

use App\Models\Support;
use App\Models\SupportReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Support $support;
    public SupportReply $reply;

    /**
     * Create a new message instance.
     */
    public function __construct(Support $support, SupportReply $reply)
    {
        $this->support = $support;
        $this->reply   = $reply;
    }

    /**
     * Email subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reply to your support ticket (TK-' . str_pad($this->support->id, 3, '0', STR_PAD_LEFT) . ')',
        );
    }


    /**
     * Email content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.support-reply',
            with: [
                'support' => $this->support,
                'reply'   => $this->reply,
            ],
        );
    }

    /**
     * Attachments (optional later)
     */
    public function attachments(): array
    {
        return [];
    }
}
