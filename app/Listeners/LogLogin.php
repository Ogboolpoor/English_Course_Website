<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        Log::channel('security')->info('User logged in.', [
            'user_id' => $event->user->getAuthIdentifier(),
            'guard' => $event->guard,
            'remember' => $event->remember,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}