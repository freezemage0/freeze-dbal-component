<?php

declare(strict_types=1);

use Freeze\Component\DBAL\Column;
use Freeze\Component\DBAL\Column\IntegerType;
use Freeze\Component\DBAL\Expression\ValueMap;
use Freeze\Component\DBAL\Mysql\Driver;
use Freeze\Component\DBAL\Schema;

require __DIR__ . '/vendor/autoload.php';

$storyTag = new Schema(
    'story_tag',
    new Column('story_id', new IntegerType(), true),
    new Column('tag_id', new IntegerType(), true),
);

$driver = new Driver('host', 'user', 'password', 'fic');

$storyTagItem = new ValueMap();
$storyTagItem->set($storyTag->getColumn('story_id'), 1);
$storyTagItem->set($storyTag->getColumn('tag_id'), 1);

var_dump($driver->getQueryBuilder($storyTag)->buildInsert($storyTagItem));
