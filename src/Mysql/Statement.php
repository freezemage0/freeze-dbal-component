<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\ResultInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;
use Freeze\Component\DBAL\Exception\QueryException;
use mysqli_result;
use mysqli_stmt;

final class Statement implements StatementInterface
{
    public function __construct(
        private readonly mysqli_stmt $statement
    ) {
    }

    public function bind(string $name, mixed $value): void
    {
        if (\is_int($value)) {
            $type = 'i';
        } elseif (\is_float($value)) {
            $type = 'd';
        } else {
            $type = 's';
        }

        $this->statement->bind_param($type, $value);
    }

    public function execute(): ?ResultInterface
    {
        if (!$this->statement->execute()) {
            throw new QueryException($this->statement->error, $this->statement->errno);
        }

        $result = $this->statement->get_result();
        return ($result instanceof mysqli_result) ? new Result($result) : null;
    }
}
