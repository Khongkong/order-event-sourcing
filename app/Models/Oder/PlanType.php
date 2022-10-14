<?php

namespace App\Models\Order;

enum PlanType: int
{
    case NORMAL = 0;
    case PACKAGE = 1;
}
