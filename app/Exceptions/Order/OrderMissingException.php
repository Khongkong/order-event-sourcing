<?php

namespace App\Exceptions\Order;

use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OrderMissingException extends ApiException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            Response::HTTP_BAD_REQUEST,
            '00001',
            'Order should be created first',
            $previous
        );
    }
}
