<?php

namespace App\Models\Order;

enum Status: int
{
    case ORDER_INITIATED = 0;
    case PLAN_CHOSEN = 1;
    case DATE_SELECTED = 2;
    case JOB_RESERVED = 3;
    case ORDER_COMPLETED = 4;
}
