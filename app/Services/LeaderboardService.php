<?php

namespace App\Services;

use App\Exceptions\PuzzleSubmissionException;

use App\Repositories\Contracts\LeaderboardRepositoryInterface;

class LeaderboardService
{
    protected $leaderboardRepository;

    public function __construct(LeaderboardRepositoryInterface $repository)
    {
        $this->leaderboardRepository = $repository;
    }

    /**
     * @return [type]
     */
    public function getLeaderboard()
    {
        try {
            return $this->leaderboardRepository->getLeaderboard();
        } catch (\Exception $e) {
            dd($e->getMessage());
            throw new PuzzleSubmissionException(
                "Unable to fetch leaderboard.",
                "LEADERBOARD_FETCH_FAILED",
                500
            );
        }
    }
}
