<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\DataColumn;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\Html\Tag\Tag;
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

    public function testFilter(): void
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
            <tr class="filters">
            <th>&nbsp;</th>
            <th><input class="form-control" name="searchModel[name]"></th>
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
                ->columns($this->createColumnsWithFilter())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterInputAttributes(): void
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
            <tr class="filters">
            <th><input class="test.class form-control" name="searchModel[id]" value="0"></th>
            <th><input class="test.class form-control" name="searchModel[name]"></th>
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
                ->columns($this->createColumnsWithFilterInputAttributes())
                ->filterModelName('searchModel')
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterPositionFooter(): void
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
            <tfoot>
            <tr>
            <td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr class="filters">
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[id]" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[name]"></th>
            </tr>
            </tfoot>
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
                ->columns($this->createColumnsWithFilters())
                ->filterModelName('searchModel')
                ->filterPosition(GridView::FILTER_POS_FOOTER)
                ->footerEnabled(true)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterPositionHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr class="filters">
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[id]" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[name]"></th>
            </tr>
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
                ->columns($this->createColumnsWithFilters())
                ->filterModelName('searchModel')
                ->filterPosition(GridView::FILTER_POS_HEADER)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterRowAttributes(): void
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
            <tr class="text-center filters">
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[id]" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[name]"></th>
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
                ->columns($this->createColumnsWithFilters())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilters(): void
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
            <tr class="filters">
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[id]" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input class="form-control" name="searchModel[name]"></th>
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
                ->columns($this->createColumnsWithFilters())
                ->filterModelName('searchModel')
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
                ->columns($this->createColumnsNotSorting())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1, true))
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

    private function createColumnsWithDataLabel(): array
    {
        return [
            DataColumn::create()->attribute('id')->dataLabel('test.id'),
            DataColumn::create()->attribute('name')->dataLabel('test.name'),
        ];
    }

    private function createColumnsWithFilter(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filter('&nbsp;'),
            DataColumn::create()
                ->attribute('name')
                ->filter('<input class="form-control" name="searchModel[name]">'),
        ];
    }

    private function createColumnsWithFilterInputAttributes(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filterAttribute('id')
                ->filterInputAttributes(['class' => 'test.class'])
                ->filterValueDefault(0),
            DataColumn::create()
                ->attribute('name')
                ->filterAttribute('name')
                ->filterInputAttributes(['class' => 'test.class'])
                ->filterValueDefault(''),
        ];
    }

    private function createColumnsWithFilters(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filterAttribute('id')
                ->filterValueDefault(0)
                ->filterAttributes(
                    [
                        'class' => 'text-center',
                        'maxlength' => '5',
                        'style' => 'width:60px',
                    ]
                ),
            DataColumn::create()
                ->attribute('name')
                ->filterAttribute('name')
                ->filterValueDefault('')
                ->filterAttributes(
                    [
                        'class' => 'text-center',
                        'maxlength' => '5',
                        'style' => 'width:60px',
                    ]
                ),
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

    private function createColumnsNotSorting(): array
    {
        return [
            DataColumn::create()->attribute('id')->notSorting(),
            DataColumn::create()->attribute('name')->value('test'),
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
