<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Example;

use Freeze\Component\DBAL\Schema\Column\IntegerType;
use Freeze\Component\DBAL\Schema\Definition\Name;
use Freeze\Component\DBAL\Schema\Definition\Primary;
use Freeze\Component\DBAL\Schema\Definition\SchemaDefinition;

#[SchemaDefinition('fic_story_tag')]
final class StoryTag
{
    public function __construct(
        #[IntegerType]
        #[Name('story_id')]
        #[Primary]
        public readonly int $storyId,

        #[IntegerType]
        #[Name('tag_id')]
        #[Primary]
        public readonly int $tagId
    ) {
    }
}
