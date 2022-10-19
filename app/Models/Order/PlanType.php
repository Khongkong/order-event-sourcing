<?php

namespace App\Models\Order;

enum PlanType: int
{
    case UNDETERMINED = 0;
    case NORMAL = 1;
    case PACKAGE = 2;
}
