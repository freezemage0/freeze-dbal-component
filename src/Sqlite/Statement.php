<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\ResultInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;
use SQLite3Result;
use SQLite3Stmt;

final class Statement implements StatementInterface
{
    public function __construct(
        private readonly SQLite3Stmt $statement
    ) {
    }

    public function bind(string $name, mixed $value): void
    {
        $this->statement->bindValue($name, $value);
    }

    public function execute(): ?ResultInterface
    {
        $result = $this->statement->execute();
        return ($result instanceof SQLite3Result) ? new Result($result) : null;
    }
}
