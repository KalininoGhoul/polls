<?php

namespace App\Http\Controllers\Poll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Poll\PollIndexRequest;
use App\Http\Resources\Poll\PollListResource;
use App\Http\Resources\Poll\PollResource;
use App\Models\Poll;
use App\Queries\Poll\PollIndexQuery;
use Illuminate\Http\JsonResponse;

class PollController extends Controller
{
    public function index(PollIndexRequest $request, PollIndexQuery $query): JsonResponse
    {
        $paginator = $query->filter($request);

        return new JsonResponse([
            'data' => PollListResource::collection($paginator->items()),
            'meta' => [
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ]
        ]);
    }

    public function show(Poll $poll): PollResource
    {
        return new PollResource($poll);
    }
}
