<?php

namespace App\Jobs;


use App\Mail\PluginUpdateMail;
use App\Models\PluginUpdateNotice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;


class SendPluginUpdateEmailJob implements ShouldQueue
{

     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $noticeId;

    public function __construct($noticeId)
    {
        $this->noticeId = $noticeId;
    }

    public function handle()
    {
        $notice = PluginUpdateNotice::with('pluginVersion')->find($this->noticeId);

        if (!$notice) return;

        try {

            Mail::to($notice->email)
                ->send(new PluginUpdateMail($notice));

            $notice->update([
                'status'  => PluginUpdateNotice::STATUS_SENT,
                'sent_at' => now()
            ]);

        } catch (\Exception $e) {

            $notice->update([
                'status'        => PluginUpdateNotice::STATUS_FAILED,
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
