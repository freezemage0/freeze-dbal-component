<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Exception;

use Freeze\Component\DBAL\Contract\ExceptionInterface;
use RuntimeException;

final class QueryException extends RuntimeException implements ExceptionInterface
{
}
