<?php

namespace App\Repositories\Contracts;

interface PuzzleRepositoryInterface
{
    public function create(array $data);

    public function saveSubmission(int $puzzleId, int $studentId, string $word, int $score);

    public function getStudentWords(int $puzzleId, int $studentId);
}
