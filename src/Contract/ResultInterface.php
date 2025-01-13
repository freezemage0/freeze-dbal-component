<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface ResultInterface
{
    public function fetch(): ?array;

    public function fetchAll(): array;
}
