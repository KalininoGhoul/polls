<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;

class CentrifugalTokenController extends Controller
{
    public function __invoke(Poll $poll): JsonResponse
    {
        return new JsonResponse([
            'token' => JWT::encode(
                payload: [
                    'exp' => now()->addSeconds(config('services.centrifugal.token.expiration'))->getTimestamp(),
                    'channels' => [$poll->slug],
                ],
                key: config('services.centrifugal.token.secret'),
                alg: 'HS256'
            ),
            'expires_in' => config('services.centrifugal.token.expiration'),
        ]);
    }
}
