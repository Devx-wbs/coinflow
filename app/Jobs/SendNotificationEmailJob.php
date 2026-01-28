<?php

namespace App\Jobs;

use App\Models\NotificationLog;
use App\Mail\PushNoticeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notificationLog;

    /**
     * Create a new job instance.
     */
    public function __construct(NotificationLog $notificationLog)
    {
        $this->notificationLog = $notificationLog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->notificationLog->user->email)
                ->send(new PushNoticeMail(
                    $this->notificationLog->notification
                ));

            $this->notificationLog->update([
                'status' => 'sent'
            ]);

        } catch (\Throwable $e) {

            $this->notificationLog->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            throw $e; // moves job to failed_jobs table
        }
    }
}
