<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ExceptionTest extends TestCase
{
    public function testGetPaginator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The paginator is not set.');
        GridView\GridView::create()->getPaginator();
    }

    public function testGetTranslator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The translator is not set.');
        GridView\GridView::create()->getTranslator();
    }

    public function testGetUrlGenerator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Url generator is not set.');
        GridView\GridView::create()->getUrlGenerator();
    }

    public function testPaginator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "paginator" property must be set.');
        GridView\GridView::create()->render();
    }

    private function createBaseListView(): GridView\BaseListView
    {
        return new class () extends GridView\BaseListView {
            public function renderItems(): string
            {
                return '';
            }
        };
    }
}
