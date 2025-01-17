<?php

declare(strict_types=1);

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Column\IntegerType;
use Freeze\Component\DBAL\Expression\Navigation;
use Freeze\Component\DBAL\Expression\Query;
use Freeze\Component\DBAL\Expression\ValueMap;
use Freeze\Component\DBAL\Mysql\Driver;
use Freeze\Component\DBAL\Schema;

require __DIR__ . '/vendor/autoload.php';

$storyTag = new Schema(
    'story_tag',
    new Column('story_id', new IntegerType(), true),
    new Column('tag_id', new IntegerType(), true),
);

$driver = new Driver('127.0.0.1', 'dbal', 'passwd', 'dbal', 3306);
$driver->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `story_tag` (
    `story_id` INT,
    `tag_id` INT,
    PRIMARY KEY (`story_id`, `tag_id`)
)
SQL);

$storyTagItem = new ValueMap();
$storyTagItem->set($storyTag->getColumn('story_id'), 1);
$storyTagItem->set($storyTag->getColumn('tag_id'), 3);

$queryBuilder = $driver->getQueryBuilder($storyTag);

$driver->query($queryBuilder->buildInsert($storyTagItem));

var_dump($driver->query($queryBuilder->buildSelect((new Query())->navigation(new Navigation(1, 0))))->fetchAll());
