<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL;

use Freeze\Component\DBAL\Contract\DriverFactoryInterface;
use Freeze\Component\DBAL\Contract\DriverInterface;
use Freeze\Component\DBAL\Exception\DriverConfigurationException;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;
use ReflectionException;
use ReflectionFunction;
use ReflectionNamedType;

final class DriverFactory implements DriverFactoryInterface
{
    private const SQLITE3_DRIVER = 'sqlite3';
    private const MYSQL_DRIVER = 'mysql';

    private array $customDrivers = [];

    /**
     * @throws DriverConfigurationException
     */
    public function create(DriverConfiguration $configuration): ?DriverInterface
    {
        if ($this->isCustomDriver($configuration->type)) {
            return $this->createCustomDriver($configuration);
        }

        return match ($configuration->type) {
            DriverFactory::SQLITE3_DRIVER => new Sqlite\Driver(
                (string) $configuration->get('filename')
            ),
            DriverFactory::MYSQL_DRIVER => new Mysql\Driver(
                (string) $configuration->get('hostname'),
                (string) $configuration->get('username'),
                $configuration->has('password') ? (string) $configuration->get('password') : '',
                $configuration->has('database') ? (string) $configuration->get('database') : ''
            ),
            default => throw new DriverConfigurationException("Undefined database type {$configuration->type}")
        };
    }

    /**
     * @throws InvalidArgumentValueException
     */
    public function registerDriver(string $type, callable $factory): void
    {
        try {
            $reflector = new ReflectionFunction($factory);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentValueException('Factory method is not callable');
        }

        $returnType = $reflector->getReturnType();
        if (!($returnType instanceof ReflectionNamedType)) {
            throw new InvalidArgumentValueException('Factory method MUST return an instance of DriverInterface');
        }

        $returnsDriver = \in_array(
            DriverInterface::class,
            \class_implements($returnType->getName()),
            true
        );
        if (!$returnsDriver) {
            throw new InvalidArgumentValueException('Factory method MUST return an instance of DriverInterface');
        }

        $this->customDrivers[$type] = $factory;
    }

    private function isCustomDriver(string $type): bool
    {
        return isset($this->customDrivers[$type]);
    }

    private function createCustomDriver(DriverConfiguration $driverConfiguration): DriverInterface
    {
        return \call_user_func($this->customDrivers[$driverConfiguration->type], $driverConfiguration);
    }
}
