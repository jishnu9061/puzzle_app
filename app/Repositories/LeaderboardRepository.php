<?php

namespace App\Repositories;

use App\Models\Submission;

use App\Repositories\Contracts\LeaderboardRepositoryInterface;

use Illuminate\Support\Facades\DB;

class LeaderboardRepository implements LeaderboardRepositoryInterface
{
    public function getLeaderboard()
    {
        return Submission::select('word', 'student_id', DB::raw('MAX(score) as score'))
            ->groupBy('word', 'student_id')
            ->orderByDesc('score')
            ->limit(10)
            ->with('student')
            ->get()
            ->map(function ($row) {
                return [
                    'student_id' => $row->student_id,
                    'student_name' => $row->student->name ?? null,
                    'word' => $row->word,
                    'score' => (int) $row->score
                ];
            });
    }
}
