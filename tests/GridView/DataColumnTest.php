<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\DataColumn;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\TestUtils\Assert;
use Forge\TestUtils\Mock;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\Route;

final class DataColumnTest extends TestCase
{
    use TestTrait;

    private array $data = [
        ['id' => 1, 'name' => 'John', 'age' => 20],
        ['id' => 2, 'name' => 'Mary', 'age' => 21],
    ];

    public function testContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithContent())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testContentAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td class="test.class" data-label="id">1</td>
            <td class="test.class" data-label="name">John</td>
            </tr>
            <tr>
            <td class="test.class" data-label="id">2</td>
            <td class="test.class" data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithContentAttributes())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testContentAttributesClosure(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td class="test.class" data-label="id">1</td>
            <td class="test.class" data-label="name">John</td>
            </tr>
            <tr>
            <td class="test.class" data-label="id">2</td>
            <td class="test.class" data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithContentAttributesClosure())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testDataLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="test.id">1</td>
            <td data-label="test.name">John</td>
            </tr>
            <tr>
            <td data-label="test.id">2</td>
            <td data-label="test.name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithDataLabel())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testLabel(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>test.id</th>
            <th>test.username</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="test.id">1</td>
            <td data-label="test.username">John</td>
            </tr>
            <tr>
            <td data-label="test.id">2</td>
            <td data-label="test.username">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithLabel())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testLabelAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th class="test.class">test.id</th>
            <th class="test.class">test.username</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="test.id">1</td>
            <td data-label="test.username">John</td>
            </tr>
            <tr>
            <td data-label="test.id">2</td>
            <td data-label="test.username">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithLabelAttributes())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testLinkSorter(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th><a href="/admin/manage/1/5?sort=id" data-sort="id">id</a></th>
            <th><a href="/admin/manage/1/5?sort=name" data-sort="name">name</a></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithLinkSorter())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testName(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th><a class="asc" href="/admin/manage?page=1&amp;pagesize=10&amp;sort=-id%2Cname" data-sort="-id,name">Id <i class="bi bi-sort-alpha-up"></i></a></th>
            <th><a class="asc" href="/admin/manage?page=1&amp;pagesize=10&amp;sort=-name%2Cid" data-sort="-name,id">Name <i class="bi bi-sort-alpha-up"></i></a></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td name="test.id" data-label="id">1</td>
            <td name="test.username" data-label="name">John</td>
            </tr>
            <tr>
            <td name="test.id" data-label="id">2</td>
            <td name="test.username" data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithName())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1, true))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->urlName('admin/manage')
                ->render()
        );
    }

    public function testNotSorting(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th><a class="asc" href="/admin/manage?page=1&amp;pagesize=10&amp;sort=-name%2Cid" data-sort="-name,id">Name <i class="bi bi-sort-alpha-up"></i></a></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">test</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">test</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithNotSorting())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1, true))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->urlName('admin/manage')
                ->render()
        );
    }

    public function testNotVisible(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithNotVisible())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->urlName('admin/manage')
                ->render()
        );
    }

    public function testSort(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th><a class="asc" href="/admin/manage?page=1&amp;pagesize=10&amp;sort=-id%2Cname" data-sort="-id,name">Id <i class="bi bi-sort-alpha-up"></i></a></th>
            <th><a class="asc" href="/admin/manage?page=1&amp;pagesize=10&amp;sort=-name%2Cid" data-sort="-name,id">Name <i class="bi bi-sort-alpha-up"></i></a></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1, true))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->urlName('admin/manage')
                ->render()
        );
    }

    public function testValue(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">test</td>
            </tr>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">test</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithValue())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testValueClosure(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumnsWithValueClosure())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    private function createColumns(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
        ];
    }

    private function createColumnsWithContent(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->content(
                    static fn (array|object $data, mixed $key, int $index): int => $data['id']
                ),
            DataColumn::create()
                ->attribute('name')
                ->content(
                    static fn (array|object $data, mixed $key, int $index): string => $data['name']
                ),
        ];
    }

    private function createColumnsWithContentAttributes(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->content(
                    static fn (array|object $data, mixed $key, int $index): int => $data['id']
                )
                ->contentAttributes(['class' => 'test.class']),
            DataColumn::create()
                ->attribute('name')
                ->content(
                    static fn (array|object $data, mixed $key, int $index): string => $data['name']
                )
                ->contentAttributes(['class' => 'test.class']),
        ];
    }

    private function createColumnsWithContentAttributesClosure(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->contentAttributes(
                    static fn (array|object $data, mixed $key, int $index): array => ['class' => 'test.class']
                ),
            DataColumn::create()
                ->attribute('name')
                ->contentAttributes(
                    static fn (array|object $data, mixed $key, int $index): array => ['class' => 'test.class']
                ),
        ];
    }

    private function createColumnsWithDataLabel(): array
    {
        return [
            DataColumn::create()->attribute('id')->dataLabel('test.id'),
            DataColumn::create()->attribute('name')->dataLabel('test.name'),
        ];
    }

    private function createColumnsWithLabel(): array
    {
        return [
            DataColumn::create()->attribute('id')->label('test.id'),
            DataColumn::create()->attribute('name')->label('test.username'),
        ];
    }

    private function createColumnsWithLabelAttributes(): array
    {
        return [
            DataColumn::create()->attribute('id')->label('test.id')->labelAttributes(['class' => 'test.class']),
            DataColumn::create()->attribute('name')->label('test.username')->labelAttributes(['class' => 'test.class']),
        ];
    }

    private function createColumnsWithLinkSorter(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->linkSorter('<a href="/admin/manage/1/5?sort=id" data-sort="id">id</a>'),
            DataColumn::create()
                ->attribute('name')
                ->linkSorter('<a href="/admin/manage/1/5?sort=name" data-sort="name">name</a>'),
        ];
    }

    private function createColumnsWithNotSorting(): array
    {
        return [
            DataColumn::create()->attribute('id')->notSorting(),
            DataColumn::create()->attribute('name')->value('test'),
        ];
    }

    private function createColumnsWithName(): array
    {
        return [
            DataColumn::create()->attribute('id')->name('test.id'),
            DataColumn::create()->attribute('name')->name('test.username'),
        ];
    }

    private function createColumnsWithNotVisible(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name')->notVisible(),
        ];
    }

    private function createColumnsWithValue(): array
    {
        return [
            DataColumn::create()->attribute('id')->value(1),
            DataColumn::create()->attribute('name')->value('test'),
        ];
    }

    private function createColumnsWithValueClosure(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->value(static fn (array|object $data): int => $data['id']),
            DataColumn::create()
                ->attribute('name')
                ->value(static fn (array|object $data): string => $data['name']),
        ];
    }
}
