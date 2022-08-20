<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\TestUtils\Assert;
use Forge\TestUtils\Mock;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\Route;
use Yiisoft\Router\UrlGeneratorInterface;

final class GridViewTest extends TestCase
{
    use TestTrait;

    private array $data = [
        ['id' => 1, 'name' => 'John', 'age' => 20],
        ['id' => 2, 'name' => 'Mary', 'age' => 21],
    ];

    public function testActionColum(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=1" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=1" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=1" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=2" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=2" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=2" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createActionColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->render()
        );
    }

    public function testAfterItemBeforeItem(): void
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
            <div class="testMe">
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            </div>
            <div class="testMe">
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            </tr>
            </div>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->afterRow(static fn () => '</div>')
                ->beforeRow(static fn () => '<div class="testMe">')
                ->columns($this->createDataColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testCheckboxColumn(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th><input class="select-on-check-all" name="checkbox-selection_all" type="checkbox" value="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="#">1</td>
            <td><input name="checkbox-selection" type="checkbox" value="0"></td>
            </tr>
            <tr>
            <td data-label="#">2</td>
            <td><input name="checkbox-selection" type="checkbox" value="1"></td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns([Column\SerialColumn::create(), Column\CheckboxColumn::create()])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testColumnGroupEnabled(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <colgroup>
            <col class="bg-primary">
            <col class="bg-success">
            </colgroup>
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
                ->columns($this->createDataColumnsWithAttributes())
                ->columnsGroupEnabled(true)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testColumnGroupEnabledWithEmpty(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <colgroup>
            <col>
            <col>
            </colgroup>
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
                ->columns($this->createDataColumns())
                ->columnsGroupEnabled(true)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testColumnGuess(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Age</th>
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="age">20</td>
            <td data-label="actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=1" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=1" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=1" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="age">21</td>
            <td data-label="actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=2" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=2" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=2" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns([])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(
                    Mock::urlGenerator(
                        [
                            Route::get('/admin/delete')->name('admin/delete'),
                            Route::get('/admin/manage')->name('admin/manage'),
                            Route::get('/admin/update')->name('admin/update'),
                            Route::get('/admin/view')->name('admin/view'),
                        ],
                    )
                )
                ->render()
        );
    }

    public function testColumnWithTranslations(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th>gridview.data.column.id</th>
            <th>gridview.data.column.name</th>
            <th>gridview.column.label.actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="#">1</td>
            <td data-label="gridview.data.column.id">1</td>
            <td data-label="gridview.data.column.name">John</td>
            <td data-label="gridview.column.label.actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=1" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=1" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=1" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="#">2</td>
            <td data-label="gridview.data.column.id">2</td>
            <td data-label="gridview.data.column.name">Mary</td>
            <td data-label="gridview.column.label.actions">
            <a class="text-decoration-none" name="view" href="/admin/view?id=2" title="View" role="button"><span>&#128270;</span></a>
            <a class="text-decoration-none" name="update" href="/admin/update?id=2" title="Update" role="button"><span>&#9998;</span></a>
            <a class="text-decoration-none" name="delete" href="/admin/delete?id=2" title="Delete" role="button" data-confirm="Are you sure you want to delete this item?" data-method="post"><span>&#10060;</span></a>
            </td>
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
                ->columnsTranslation(true)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->render()
        );
    }

    public function testDataColumnWithFilter(): void
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
                ->columns($this->createDataColumnsWithFilters())
                ->filterModelName('searchModel')
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testDataColumnWithFilterPositionFooter(): void
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
                ->columns($this->createDataColumnsWithFilters())
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

    public function testDataColumnWithFilterPositionHeader(): void
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
                ->columns($this->createDataColumnsWithFilters())
                ->filterModelName('searchModel')
                ->filterPosition(GridView::FILTER_POS_HEADER)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testDataColumnWithFilterRowAttributes(): void
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
                ->columns($this->createDataColumnsWithFilters())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testEmptyCell(): void
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
            <td data-label="id">Empty cell</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns([Column\DataColumn::create()->attribute('id')])
                ->emptyCell('Empty cell')
                ->id('w1-grid')
                ->paginator($this->createPaginator([['id' => '']], 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testEmptyText(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td colspan="4">Not found.</td>
            </tr>
            </tbody>
            </table>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumns())
                ->emptyText('Not found.')
                ->id('w1-grid')
                ->paginator($this->createPaginator([], 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFooterRowAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th>Id</th>
            <th>Name</th>
            </tr>
            </thead>
            <tfoot>
            <tr class="text-primary">
            <td>Total:</td><td>2</td><td>2</td>
            </tr>
            </tfoot>
            <tbody>
            <tr>
            <td data-label="#">1</td>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr>
            <td data-label="#">2</td>
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
                ->columns($this->createColumnsWithFooter())
                ->footerEnabled(true)
                ->footerRowAttributes(['class' => 'text-primary'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            List of users
            </div>
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
                ->columns($this->createDataColumns())
                ->header('List of users')
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testHeaderIntoGrid(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <div>
            List of users
            </div>
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
                ->columns($this->createDataColumns())
                ->header('List of users')
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->layout('')
                ->layoutGridTable("{header}\n{items}\n{summary}\n{pager}")
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testHeaderRowAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr class="text-primary">
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
                ->columns($this->createDataColumns())
                ->headerRowAttributes(['class' => 'text-primary'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testHeaderTableEnabledWithFalse(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
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
                ->columns($this->createDataColumns())
                ->headerTableEnabled(false)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testRadioColumn(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="#">1</td>
            <td><input name="radio-selection" type="radio" value="0"></td>
            </tr>
            <tr>
            <td data-label="#">2</td>
            <td><input name="radio-selection" type="radio" value="1"></td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns([Column\SerialColumn::create(), Column\RadioColumn::create()])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testRenderWithEmptyData(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>#</th>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td colspan="4">No results found.</td>
            </tr>
            </tbody>
            </table>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator([], 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testRowAttributes(): void
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
            <tr class="text-primary">
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            </tr>
            <tr class="text-primary">
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
                ->columns($this->createDataColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->rowAttributes(['class' => 'text-primary'])
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testTableAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table table-striped table-bordered">
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
                ->columns($this->createDataColumns())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->tableAttributes(['class' => 'table table-striped table-bordered'])
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    private function createActionColumns(): array
    {
        return [
            Column\ActionColumn::create(),
        ];
    }

    private function createColumns(): array
    {
        return [
            Column\SerialColumn::create(),
            Column\DataColumn::create()->attribute('id'),
            Column\DataColumn::create()->attribute('name'),
            Column\ActionColumn::create(),
        ];
    }

    private function createColumnsWithFooter(): array
    {
        return [
            Column\SerialColumn::create()->footer('Total:'),
            Column\DataColumn::create()->attribute('id')->footer('2'),
            Column\DataColumn::create()->attribute('name')->footer('2'),
        ];
    }

    private function createDataColumns(): array
    {
        return [
            Column\DataColumn::create()->attribute('id'),
            Column\DataColumn::create()->attribute('name'),
        ];
    }

    private function createDataColumnsWithAttributes(): array
    {
        return [
            Column\DataColumn::create()->attribute('id')->attributes(['class' => 'bg-primary']),
            Column\DataColumn::create()->attribute('name')->attributes(['class' => 'bg-success']),
        ];
    }

    private function createDataColumnsWithFilters(): array
    {
        return [
            Column\DataColumn::create()
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
            Column\DataColumn::create()
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

    private function createUrlGenerator(): UrlGeneratorInterface
    {
        return Mock::urlGenerator(
            [
                Route::get('/admin/delete')->name('admin/delete'),
                Route::get('/admin/manage')->name('admin/manage'),
                Route::get('/admin/update')->name('admin/update'),
                Route::get('/admin/view')->name('admin/view'),
            ],
        );
    }
}
