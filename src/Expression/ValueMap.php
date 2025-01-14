<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Expression;

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Contract\StatementInterface;
use Iterator;
use SplObjectStorage;

final class ValueMap implements Iterator
{
    /**
     * @var SplObjectStorage<Column, mixed>
     */
    private readonly SplObjectStorage $map;

    public function __construct()
    {
        $this->map = new SplObjectStorage();
    }

    public function set(Column $column, mixed $value): void
    {
        $this->map->attach($column, $value);
    }

    public function bind(StatementInterface $statement): void
    {
        foreach ($this as $column => $value) {
            $statement->bind($column, $value);
        }
    }

    public function current(): mixed
    {
        return $this->map->getInfo();
    }

    public function next(): void
    {
        $this->map->next();
    }

    public function key(): mixed
    {
        return $this->map->current()->name;
    }

    public function valid(): bool
    {
        return $this->map->valid();
    }

    public function rewind(): void
    {
        $this->map->rewind();
    }
}
