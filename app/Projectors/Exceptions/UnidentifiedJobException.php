<?php

namespace App\Projectors\Exceptions;

use Throwable;

class UnidentifiedJobException extends OrderProcessingException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Some jobs are not found', 0, $previous);
    }
}
