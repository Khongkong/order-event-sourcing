<?php

namespace App\Exceptions\Order;

use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InvalidJobException extends ApiException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            Response::HTTP_BAD_REQUEST,
            '00002',
            'Some job ids are invalid',
            $previous
        );
    }
}
