<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class LogPasswordReset
{
    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        Log::channel('security')->info('Password reset completed.', [
            'user_id' => $event->user->getAuthIdentifier(),
            'email' => $event->user->email ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}