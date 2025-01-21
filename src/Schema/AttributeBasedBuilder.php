<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Schema;

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Contract\ColumnTypeInterface;
use Freeze\Component\DBAL\Exception\InvalidArgumentValueException;
use Freeze\Component\DBAL\Schema;
use Freeze\Component\DBAL\Schema\Definition\SchemaDefinition;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

final class AttributeBasedBuilder
{
    /**
     * @throws InvalidArgumentValueException
     */
    public function build(string $entityClassName): Schema
    {
        try {
            $reflector = new ReflectionClass($entityClassName);
        } catch (ReflectionException $e) {
            throw new RuntimeException("{$entityClassName} not found", previous: $e);
        }

        $attributes = $reflector->getAttributes(SchemaDefinition::class);
        if (empty($attributes)) {
            throw new InvalidArgumentValueException("{$entityClassName} is not a schema class");
        }

        /** @var SchemaDefinition $schemaDefinition */
        $schemaDefinition = $attributes[0]->newInstance();

        $columns = [];
        foreach ($reflector->getProperties() as $property) {
            $columnAttributes = $property->getAttributes();

            $name = null;
            $type = null;
            $isPrimary = false;
            $isNullable = false;

            foreach ($columnAttributes as $attribute) {
                $attribute = $attribute->newInstance();
                if ($attribute instanceof Schema\Definition\Name) {
                    $name = $attribute->value;
                }

                if ($attribute instanceof ColumnTypeInterface) {
                    $type = $attribute;
                }

                if ($attribute instanceof Schema\Definition\Primary) {
                    $isPrimary = true;
                }

                if ($attribute instanceof Schema\Definition\Nullable) {
                    $isNullable = true;
                }
            }

            $columns[] = new Column($name, $type, $isPrimary, $isNullable);
        }

        return new Schema($schemaDefinition->tableName, ...$columns);
    }
}
