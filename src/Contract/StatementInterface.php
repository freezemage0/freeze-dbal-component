<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface StatementInterface
{
    public function bind(string $name, mixed $value): void;

    public function execute(): ?ResultInterface;
}
