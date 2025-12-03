<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\LeaderboardService;

use App\Traits\ApiResponseTrait;

class LeaderboardController extends Controller
{
    use ApiResponseTrait;

    protected $service;

    public function __construct(LeaderboardService $service)
    {
        $this->service = $service;
    }

    /**
     * @return [type]
     */
    public function index()
    {
        $leaderboard = $this->service->getLeaderboard();

        return $this->makeSuccessResponse(
            $leaderboard->toArray(),
            'Leaderboard fetched successfully'
        );
    }
}
