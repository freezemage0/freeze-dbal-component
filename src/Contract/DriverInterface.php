<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface DriverInterface
{
    public function query(string $query): ?ResultInterface;

    public function prepare(string $statement): ?StatementInterface;

    public function connect(): void;

    public function disconnect(): void;
}
