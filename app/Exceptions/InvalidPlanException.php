<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvalidPlanException extends ApiException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, '00003', 'Plan is invalid', $previous);
    }
}
