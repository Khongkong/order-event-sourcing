<?php

namespace App\Projectors\Exceptions;

use Throwable;

class PlanNotFoundException extends OrderProcessingException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Plan not found', 0, $previous);
    }
}
