<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ApiException extends HttpException
{
    protected string $errorCode;
    protected string $errorMessage;

    public function __construct(int $statusCode, string $errorCode, string $errorMessage, Throwable $previous = null)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        parent::__construct($statusCode, $errorMessage, $previous);
    }

    public function report(): ?bool
    {
        return false;
    }

    public function render($request): JsonResponse
    {
        return response()
            ->json([
                'code' => $this->errorCode,
                'message' => $this->errorMessage,
            ])
            ->setStatusCode($this->getStatusCode());
    }
}
