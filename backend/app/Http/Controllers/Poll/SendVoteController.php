<?php

namespace App\Http\Controllers\Poll;

use App\Actions\Poll\SendVoteAction;
use App\Events\PollVoteAcceptedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Poll\SendVoteRequest;
use App\Models\Poll;
use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\Response;

class SendVoteController extends Controller
{
    public function __invoke(
        SendVoteRequest $request,
        Poll $poll,
        SendVoteAction $sendVoteAction,
        #[Authenticated]
        User $user,
    ): Response
    {
        $sendVoteAction->handle($user, $poll, $request->options);

        event(new PollVoteAcceptedEvent($poll));

        return response()->noContent();
    }
}
