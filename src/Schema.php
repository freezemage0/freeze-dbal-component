<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL;

class Schema
{
    public readonly array $columns;
    private readonly array $primary;

    public function __construct(
        public readonly string $name,
        Column ...$columns
    ) {
        $this->columns = $columns;
    }

    /**
     * @return array<Column>
     */
    public function getPrimary(): array
    {
        if (!isset($this->primary)) {
            $this->primary = \array_filter($this->columns, static fn (Column $c): bool => $c->primary);
        }

        return $this->primary;
    }

    public function getColumn(string $name): ?Column
    {
        foreach ($this->columns as $column) {
            if ($column->name === $name) {
                return $column;
            }
        }

        return null;
    }
}
