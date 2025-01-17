<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Mysql;

use Freeze\Component\DBAL\Contract\DriverInterface;
use Freeze\Component\DBAL\Contract\IdentityGeneratorInterface;
use Freeze\Component\DBAL\Contract\LockingServiceInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Contract\ResultInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;
use Freeze\Component\DBAL\Contract\TransactionServiceInterface;
use Freeze\Component\DBAL\Exception\ConnectionException;
use Freeze\Component\DBAL\Exception\QueryException;
use Freeze\Component\DBAL\Schema;
use mysqli;
use mysqli_result;
use mysqli_stmt;

final class Driver implements DriverInterface
{
    private mysqli $driver;

    public function __construct(
        private readonly string $hostname,
        private readonly string $username,
        private readonly string $password,
        private readonly string $database,
        private readonly int $port = 3306
    ) {
    }

    public function query(string $query): ?ResultInterface
    {
        $driver = $this->driver();

        $result = $driver->query($query);
        if ($result === false) {
            throw new QueryException($driver->error, $driver->errno);
        }

        return ($result instanceof mysqli_result) ? new Result($result) : null;
    }

    public function prepare(string $statement): ?StatementInterface
    {
        $driver = $this->driver();

        $statement = $driver->prepare($statement);
        if ($statement === false) {
            throw new QueryException($driver->error, $driver->errno);
        }

        return ($statement instanceof mysqli_stmt) ? new Statement($statement) : null;
    }

    public function connect(): void
    {
        if (!isset($this->driver)) {
            $driver = new mysqli(
                $this->hostname,
                $this->username,
                $this->password,
                $this->database,
                $this->port
            );

            if ($driver->connect_errno) {
                throw new ConnectionException($driver->connect_error, $driver->connect_errno);
            }

            $this->driver = $driver;
        }
    }

    public function disconnect(): void
    {
        if (isset($this->driver)) {
            $this->driver->close();
            unset($this->driver);
        }
    }

    private function driver(): mysqli
    {
        if (!isset($this->driver)) {
            $this->connect();
        }

        return $this->driver;
    }

    public function getIdentityGenerator(): IdentityGeneratorInterface
    {
        return new IdentityGenerator($this->driver());
    }

    public function getTransactionManager(): TransactionServiceInterface
    {
        return new TransactionService($this);
    }

    public function getLockingService(): LockingServiceInterface
    {
        return new LockingService($this);
    }

    public function getQueryBuilder(Schema $schema): QueryBuilderInterface
    {
        $quoteStrategy = new EscapeStrategy($this->driver());

        return new QueryBuilder($schema, new ExpressionBuilder($quoteStrategy), $quoteStrategy);
    }
}
