<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Sqlite;

use Freeze\Component\DBAL\Contract\DriverInterface;
use Freeze\Component\DBAL\Contract\IdentityGeneratorInterface;
use Freeze\Component\DBAL\Contract\LockingServiceInterface;
use Freeze\Component\DBAL\Contract\QueryBuilderInterface;
use Freeze\Component\DBAL\Contract\ResultInterface;
use Freeze\Component\DBAL\Contract\StatementInterface;
use Freeze\Component\DBAL\Contract\TransactionServiceInterface;
use Freeze\Component\DBAL\Exception\ConnectionException;
use Freeze\Component\DBAL\Exception\QueryException;
use Freeze\Component\DBAL\Fallback\NullLockingService;
use Freeze\Component\DBAL\Schema;
use SQLite3;
use SQLite3Result;
use SQLite3Stmt;

final class Driver implements DriverInterface
{
    private ?SQLite3 $driver = null;

    public function __construct(
        private readonly ?string $filepath
    ) {
    }

    public function query(string $query): ?ResultInterface
    {
        $driver = $this->driver();

        $result = $driver->query($query);
        if ($driver->lastErrorCode() !== 0) {
            throw new QueryException($driver->lastErrorMsg(), $driver->lastErrorCode());
        }

        return ($result instanceof SQLite3Result) ? new Result($result) : null;
    }

    public function prepare(string $statement): ?StatementInterface
    {
        $driver = $this->driver();

        $statement = $driver->prepare($statement);
        if ($driver->lastErrorCode() !== 0) {
            throw new QueryException($driver->lastErrorMsg(), $driver->lastErrorCode());
        }

        return ($statement instanceof SQLite3Stmt) ? new Statement($statement) : null;
    }

    public function connect(): void
    {
        if ($this->driver === null) {
            $driver = new SQLite3($this->filepath);
            if ($driver->lastErrorCode() !== 0) {
                throw new ConnectionException($driver->lastErrorMsg(), $driver->lastErrorCode());
            }
            $this->driver = $driver;
        }
    }

    public function disconnect(): void
    {
        if ($this->driver !== null) {
            $this->driver->close();
            $this->driver = null;
        }
    }

    private function driver(): SQLite3
    {
        $this->connect();
        return $this->driver;
    }

    public function getIdentityGenerator(): IdentityGeneratorInterface
    {
        return new IdentityGenerator($this->driver());
    }

    public function getTransactionService(): TransactionServiceInterface
    {
        return new TransactionService($this);
    }

    public function getLockingService(): LockingServiceInterface
    {
        return new NullLockingService();
    }

    public function getQueryBuilder(Schema $schema): QueryBuilderInterface
    {
        // TODO: Implement getQueryBuilder() method.
    }
}
