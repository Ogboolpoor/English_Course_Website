<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
{
    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        Log::channel('security')->warning('Login failed.', [
            'user_id' => $event->user?->getAuthIdentifier(),
            'guard' => $event->guard,
            'email' => $event->credentials['email'] ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}