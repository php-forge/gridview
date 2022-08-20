<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\DataColumn;
use Forge\TestUtils\Assert;
use PHPUnit\Framework\TestCase;

final class DataColumnTest extends TestCase
{
    public function testFilter(): void
    {
        $filter = Assert::inaccessibleProperty(
            DataColumn::create()->filter('<input class="form-control" name="searchModel[id]" value="0">'),
            'filter',
        );

        $this->assertSame('<input class="form-control" name="searchModel[id]" value="0">', $filter);
    }

    public function testFilterInputAttributes(): void
    {
        $filterInputAttributes = Assert::inaccessibleProperty(
            DataColumn::create()->filterInputAttributes(['class' => 'test.class']),
            'filterInputAttributes',
        );

        $this->assertSame(['class' => 'test.class'], $filterInputAttributes);
    }

    public function testGetDataCellValue(): void
    {
        $this->assertSame('0', DataColumn::create()->value(0)->getDataCellValue(['id' => 0], 0, 0));
        $this->assertSame(
            '0',
            DataColumn::create()->value(static fn ($data): int => $data['id'])->getDataCellValue(['id' => 0], 0, 0),
        );
    }

    public function testNotSorting(): void
    {
        $sortingEnabled = Assert::inaccessibleProperty(
            DataColumn::create()->notSorting(),
            'sortingEnabled',
        );
        $this->assertSame(false, $sortingEnabled);
    }

    public function testRenderDataCellContentWithContent(): void
    {
        $renderDataCellContent = Assert::invokeMethod(
            DataColumn::create()->content(static fn ($data): string => '0'),
            'renderDataCellContent',
            [['id' => 0], 0, 0],
        );
        $this->assertSame('0', $renderDataCellContent);
    }

    public function testRenderFilterCellContent(): void
    {
        $renderFilterCellContent = Assert::invokeMethod(DataColumn::create(), 'renderFilterCellContent');
        $this->assertEmpty($renderFilterCellContent);
    }

    public function testRenderFilterCellContentWithFilter(): void
    {
        $renderFilterCellContent = Assert::invokeMethod(
            DataColumn::create()->filter('<input class="form-control" name="searchModel[id]" value="0">'),
            'renderFilterCellContent',
        );
        $this->assertSame('<input class="form-control" name="searchModel[id]" value="0">', $renderFilterCellContent);
    }

    public function testRenderHeaderCellContentWithAttributeAndLinkSorter(): void
    {
        $renderHeaderCellContent = Assert::invokeMethod(
            DataColumn::create()->attribute('id')->linkSorter('<a href="/admin/1/5?sort=id" data-sort="id">id</a>'),
            'renderHeaderCellContent',
        );
        $this->assertSame('<a href="/admin/1/5?sort=id" data-sort="id">id</a>', $renderHeaderCellContent);
    }
}
