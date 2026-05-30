<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;

class LogLockout
{
    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
        Log::channel('security')->warning('Authentication lockout detected.', [
            'email' => $event->request->input('email'),
            'ip' => $event->request->ip(),
            'user_agent' => $event->request->userAgent(),
        ]);
    }
}