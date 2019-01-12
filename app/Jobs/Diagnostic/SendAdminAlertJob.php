<?php

namespace App\Jobs\Diagnostic;

use App\Jobs\BaseJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendAdminAlertJob extends BaseJob implements ShouldQueue
{
    public function handle()
    {
        $lines = [];

        $this->maybeAppendFailedJobs($lines);

        $this->maybeAppendErrorLogSize($lines);

        if (count($lines) === 0) {
            return;
        }

        Mail::raw(implode("\r\n", $lines), function (Message $message) {
            $email = config('keys.admin_email');

            $date = now()->format('Y-m-d');

            $message->to([$email => 'Admin'])->subject("Admin Alert ($date) | Keys.lol");
        });
    }

    protected function maybeAppendFailedJobs(array &$lines)
    {
        $failedJobCount = DB::table('failed_jobs')->count();

        if ($failedJobCount) {
            $lines[] = 'There are '.$failedJobCount.' failed jobs!';
        }
    }

    protected function maybeAppendErrorLogSize(array &$lines)
    {
        $logFilePath = storage_path('logs/laravel.log');

        $errorLogSize = file_exists($logFilePath) ? filesize($logFilePath) : 0;

        if ($errorLogSize) {
            $lines[] = 'Error log is '.$errorLogSize.' bytes big!';
        }
    }
}
