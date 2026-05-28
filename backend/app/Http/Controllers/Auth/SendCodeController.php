<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendAuthCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Jobs\Auth\SendAuthCodeJob;
use Illuminate\Http\Response;

class SendCodeController extends Controller
{
    public function __invoke(SendCodeRequest $request, SendAuthCodeAction $sendAuthCodeAction): Response
    {
        dispatch(new SendAuthCodeJob($request));

        return response()->noContent();
    }
}
