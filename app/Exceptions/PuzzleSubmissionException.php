<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponseTrait;

class PuzzleSubmissionException extends Exception
{
    use ApiResponseTrait;

    protected string $errorCode;

    public function __construct(string $message, string $errorCode = '', int $code = 400)
    {
        parent::__construct($message, $code);
        $this->errorCode = $errorCode;
    }

    /**
     * Custom JSON response when thrown.
     */
    public function render($request)
    {
        return $this->makeErrorResponse(
            $this->getMessage(),
            $this->errorCode,
            $this->getCode() ?: 400
        );
    }
}
