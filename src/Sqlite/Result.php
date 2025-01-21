<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\ResultInterface;
use SQLite3Result;

use const SQLITE3_ASSOC;

final class Result implements ResultInterface
{
    public function __construct(
        private readonly SQLite3Result $result
    ) {
    }

    public function fetch(): ?array
    {
        $row = $this->result->fetchArray(SQLITE3_ASSOC);
        return $row !== false ? $row : null;
    }

    public function fetchAll(): array
    {
        $rows = [];
        while ($row = $this->fetch()) {
            $rows[] = $row;
        }

        return $rows;
    }
}
