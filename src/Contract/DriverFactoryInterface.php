<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

use Freeze\Component\DBAL\DriverConfiguration;
use Freeze\Component\DBAL\Exception\DriverConfigurationException;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;

interface DriverFactoryInterface
{
    /**
     * @throws DriverConfigurationException
     */
    public function create(DriverConfiguration $configuration): ?DriverInterface;

    /**
     * @throws InvalidArgumentValueException
     */
    public function registerDriver(string $type, callable $factory): void;
}
