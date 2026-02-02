<?php

namespace App\Mail;

use App\Models\PluginUpdateNotice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PluginUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public PluginUpdateNotice $notice;

    /**
     * Create a new message instance.
     */
    public function __construct(PluginUpdateNotice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Email Subject
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Plugin Update Available - Version ' .
                     $this->notice->pluginVersion->version
        );
    }

    /**
     * Email Content View
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.plugin_update',
            with: [
                'notice' => $this->notice,
            ]
        );
    }

    /**
     * Attachments (optional)
     */
    public function attachments(): array
    {
        return [];
    }
}
