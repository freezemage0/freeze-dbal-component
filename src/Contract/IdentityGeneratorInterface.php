<?php

declare(strict_types=1);

namespace Freeze\Component\DBAL\Contract;

interface IdentityGeneratorInterface
{
    public function createIdentity(): int|string;
}
