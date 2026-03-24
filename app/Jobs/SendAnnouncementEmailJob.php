<?php

namespace App\Jobs;

use App\Mail\AnnouncementMail;
use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendAnnouncementEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    /**
     * @param  Collection<int, array{name: string, email: string}>  $recipients
     */
    public function __construct(
        public readonly Announcement $announcement,
        public readonly Collection $recipients,
    ) {}

    public function handle(): void
    {
        foreach ($this->recipients as $recipient) {
            try {
                Mail::to($recipient['email'])
                    ->send(new AnnouncementMail($this->announcement, $recipient['name']));
            } catch (Throwable $e) {
                Log::error('Announcement email failed for: '.$recipient['email'].' | '.$e->getMessage());
            }
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error('SendAnnouncementEmailJob failed: '.$exception->getMessage(), [
            'announcement_id' => $this->announcement->id,
        ]);
    }
}
