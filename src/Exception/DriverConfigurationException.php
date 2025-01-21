<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Exception;

use Exception;
use Freeze\Component\DBAL\Contract\ExceptionInterface;

final class DriverConfigurationException extends Exception implements ExceptionInterface
{
}
