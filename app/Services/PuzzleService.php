<?php

namespace App\Services;

use App\Exceptions\PuzzleSubmissionException;

use App\Models\Puzzle;

use App\Repositories\Contracts\PuzzleRepositoryInterface;

use Illuminate\Support\Facades\Http;


class PuzzleService
{
    protected $repo;

    public function __construct(PuzzleRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param string $puzzleString
     *
     * @return [type]
     */
    public function createPuzzle(string $puzzleString)
    {
        return $this->repo->create([
            'puzzle_string' => strtolower($puzzleString)
        ]);
    }

    /**
     * @param mixed $puzzleId
     * @param array $data
     *
     * @return [type]
     */
    public function submitWord($puzzleId, array $data)
    {
        try {
            $word = strtolower($data['word']);
            $studentId = $data['student_id'];

            $puzzle = Puzzle::find($puzzleId);

            if (!$puzzle) {
                throw new PuzzleSubmissionException("Puzzle not found.");
            }

            $previousWords = $this->repo->getStudentWords($puzzle->id, $studentId);

            $lettersLeft = $this->calculateLettersLeft($puzzle->puzzle_string, $previousWords);


            if (! $this->canFormWord($word, $lettersLeft)) {
                throw new PuzzleSubmissionException("Cannot form this word with remaining letters", "LETTER_ERROR");
            }

            if (! $this->isValidEnglishWord($word)) {
                throw new PuzzleSubmissionException("Not a valid English word", "WORD_INVALID");
            }

            $score = strlen($word);

            return $this->repo->saveSubmission($puzzleId, $studentId, $word, $score);
        } catch (PuzzleSubmissionException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            throw new PuzzleSubmissionException("Unable to submit word. Please try again.");
        }
    }

    /**
     * @param string $puzzleString
     * @param array $previousWords
     *
     * @return array
     */
    protected function calculateLettersLeft(string $puzzleString, array $previousWords): array
    {
        $letters = str_split($puzzleString);

        foreach ($previousWords as $word) {
            foreach (str_split($word) as $char) {
                $key = array_search($char, $letters);
                if ($key !== false) {
                    unset($letters[$key]);
                }
            }
        }

        return array_values($letters);
    }

    /**
     * @param string $word
     * @param array $lettersLeft
     *
     * @return bool
     */
    protected function canFormWord(string $word, array $lettersLeft): bool
    {
        $tempLetters = $lettersLeft;

        foreach (str_split($word) as $char) {
            $key = array_search($char, $tempLetters);
            if ($key === false) {
                return false;
            }
            unset($tempLetters[$key]);
        }

        return true;
    }

    /**
     * @param string $word
     *
     * @return bool
     */
    protected function isValidEnglishWord(string $word): bool
    {
        try {
            $response = Http::timeout(5)->withoutVerifying()->get("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");

            if ($response->successful()) {
                return true;
            }

            if ($response->status() === 404) {
                return false;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
