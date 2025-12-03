<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\PuzzleStoreRequest;
use App\Http\Requests\PuzzleSubmitRequest;

use App\Services\PuzzleService;

use App\Traits\ApiResponseTrait;

class PuzzleController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(PuzzleService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PuzzleStoreRequest $request
     *
     * @return [type]
     */
    public function store(PuzzleStoreRequest $request)
    {
        $puzzle = $this->service->createPuzzle($request->puzzle_string);

        return $this->makeSuccessResponse(
            ['puzzle' => $puzzle],
            'Puzzle created successfully',
            201
        );
    }

    /**
     * @param PuzzleSubmitRequest $request
     * @param mixed $id
     *
     * @return [type]
     */
    public function submitWord(PuzzleSubmitRequest $request, $id)
    {
        $submission = $this->service->submitWord($id, $request->validated());

        return $this->makeSuccessResponse(
            ['submission' => $submission],
            'Word submitted successfully',
            200
        );
    }
}
