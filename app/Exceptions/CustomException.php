<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CustomException extends Exception
{
    public $statusCode;
    public $devError;

    public function __construct($devError = "",$message, $statusCode = 500)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->devError = $devError;
        $this->logError();
    }

    public function logError()
    {
        Log::error($this->getMessage(), [
            'stack_trace' => $this->getTraceAsString(),
            'dev_message' => $this->devError,
        ]);
    }

    public function render(Request $request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->statusCode);
    }
}