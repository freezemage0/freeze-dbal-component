<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

use Freeze\Component\DBAL\Schema;

interface DriverInterface
{
    public function query(string $query): ?ResultInterface;

    public function prepare(string $statement): ?StatementInterface;

    public function connect(): void;

    public function disconnect(): void;

    public function getIdentityGenerator(): IdentityGeneratorInterface;

    public function getTransactionService(): TransactionServiceInterface;

    public function getLockingService(): LockingServiceInterface;

    public function getQueryBuilder(Schema $schema): QueryBuilderInterface;
}
