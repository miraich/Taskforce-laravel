<?php

namespace public\Enums;

enum StatusesEnum: int
{
    case STATUS_NEW = 1;
    case CANCELED = 2;
    case IN_PROGRESS = 3;
    case COMPLETED = 4;
    case FAILED = 5;
}
