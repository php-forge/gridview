<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\Column;

use Forge\GridView\Column\ActionColumn;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ExceptionTest extends TestCase
{
    public function testGetUrlGenerator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url generator is not set');
        ActionColumn::create()->getUrlGenerator();
    }
}
