<?php

namespace App\Jobs\Auth;

use App\Actions\Auth\SendAuthCodeAction;
use App\Http\Requests\Auth\SendCodeRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendAuthCodeJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private SendCodeRequest $request
    )
    {
        $this->onQueue('auth');
    }

    public function handle(SendAuthCodeAction $sendAuthCodeAction): void
    {
        $sendAuthCodeAction->handle($this->request);
    }
}
