<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Forge\GridView\Widget\Toolbar;

final class ImmutableTest extends TestCase
{
    public function testToolbar(): void
    {
        $toolbar = Toolbar::create();
        $this->assertNotSame($toolbar, $toolbar->containerLeft(false));
        $this->assertNotSame($toolbar, $toolbar->containerLeftClass(''));
        $this->assertNotSame($toolbar, $toolbar->containerLeftAttributes([]));
        $this->assertNotSame($toolbar, $toolbar->containerRightClass(''));
        $this->assertNotSame($toolbar, $toolbar->containerRightAttributes([]));
        $this->assertNotSame($toolbar, $toolbar->contentLeft(''));
        $this->assertNotSame($toolbar, $toolbar->contentRight(''));
    }
}
