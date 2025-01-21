<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL;

use Freeze\Component\DBAL\Exception\DriverConfigurationException;

final class DriverConfiguration
{
    public function __construct(
        public readonly string $type,
        private readonly array $options = []
    ) {
    }

    /**
     * @throws DriverConfigurationException
     */
    public function get(string $option): mixed
    {
        if (!$this->has($option)) {
            throw new DriverConfigurationException("Parameter {$option} not found in configuration");
        }

        return $this->options[$option];
    }

    public function has(string $option): bool
    {
        return isset($this->options[$option]) || \array_key_exists($option, $this->options);
    }
}
