<?php

namespace App\Repositories;

use App\Exceptions\PuzzleSubmissionException;

use App\Models\Puzzle;
use App\Models\Submission;

use App\Repositories\Contracts\PuzzleRepositoryInterface;

class PuzzleRepository implements PuzzleRepositoryInterface
{
    protected $submission;

    protected $puzzle;

    public function __construct(Puzzle $puzzle, Submission $submission)
    {
        $this->puzzle = $puzzle;
        $this->submission = $submission;
    }

    public function create(array $data)
    {
        return $this->puzzle->create($data);
    }

    public function saveSubmission(int $puzzleId, int $studentId, string $word, int $score)
    {
        try {
            return $this->submission->create([
                'puzzle_id'  => $puzzleId,
                'student_id' => $studentId,
                'word'  => strtolower($word),
                'score' => $score,
            ]);
        } catch (\Exception $e) {
            throw new PuzzleSubmissionException("Database error: Unable to save submission.");
        }
    }

    public function getStudentWords(int $puzzleId, int $studentId)
    {
        return $this->submission
            ->where('puzzle_id', $puzzleId)
            ->where('student_id', $studentId)
            ->pluck('word')
            ->toArray();
    }
}
