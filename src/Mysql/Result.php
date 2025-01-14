<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\ResultInterface;
use mysqli_result;

final class Result implements ResultInterface
{
    public function __construct(
        private readonly mysqli_result $result
    ) {
    }

    public function fetch(): ?array
    {
        $row = $this->result->fetch_assoc();
        return $row !== false ? $row : null;
    }

    public function fetchAll(): array
    {
        return $this->result->fetch_all(\MYSQLI_ASSOC);
    }
}
