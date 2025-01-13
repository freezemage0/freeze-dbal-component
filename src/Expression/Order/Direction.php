<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression\Order;

enum Direction: string
{
    case Ascending = 'ASC';
    case Descending = 'DESC';
}
