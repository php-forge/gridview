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

final class DataColumnFilterTest extends TestCase
{
    use TestTrait;

    private array $data = [
        ['id' => 1, 'name' => 'John', 'age' => 20],
        ['id' => 2, 'name' => 'Mary', 'age' => 21],
    ];

    private array $dataWithDate = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'birthday' => '2000-01-01'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'birthday' => '2000-01-02'],
    ];

    private array $dataWithDateTime = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'birthday' => '2000-01-01 00:00:00'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'birthday' => '2000-01-02 00:00:00'],
    ];

    private array $dataWithEmail = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'email' => 'test1@example.com'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'email' => 'test2@example.com'],
    ];

    private array $dataWithMonth = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'month' => '2000-01'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'month' => '2000-02'],
    ];

    private array $dataWithTelephone = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'telephone' => '1 (555) 123-4567'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'telephone' => '1 (555) 123-4568'],
    ];

    private array $dataWithTime = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'time' => '12:00:00'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'time' => '12:00:01'],
    ];

    private array $dataWithUrl = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'url' => 'http://example.com'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'url' => 'http://example.org'],
    ];

    private array $dataWithWeek = [
        ['id' => 1, 'name' => 'John', 'age' => 20, 'week' => '2000-W01'],
        ['id' => 2, 'name' => 'Mary', 'age' => 21, 'week' => '2000-W02'],
    ];

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
            <th><input name="searchModel[name]"></th>
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
                ->columns($this->createDataColumnsWithFilter())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterDate(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Birthday</th>
            </tr>
            <tr class="filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="birthday" type="date"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="birthday">2000-01-01</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="birthday">2000-01-02</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterDate())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithDate, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterDateTime(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Birthday</th>
            </tr>
            <tr class="filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="birthday" type="datetime-local"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="birthday">2000-01-01 00:00:00</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="birthday">2000-01-02 00:00:00</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterDateTime())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithDateTime, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterEmail(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            </tr>
            <tr class="filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="email" type="email"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="email">test1@example.com</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="email">test2@example.com</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterEmail())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithEmail, 10, 1))
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
            <th><input class="test.class" name="searchModel[id]" type="text" value="0"></th>
            <th><input class="test.class" name="searchModel[name]" type="text"></th>
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
                ->columns($this->createDataColumnsWithFilterInputAttributes())
                ->filterModelName('searchModel')
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterMonth(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Month</th>
            </tr>
            <tr class="filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="month" type="month"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="month">2000-01</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="month">2000-02</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterMonth())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithMonth, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterNumber(): void
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
            <th><input name="id" type="number"></th>
            <td>&nbsp;</td>
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
                ->columns($this->createDataColumnsWithFilterNumber())
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
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[id]" type="text" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[name]" type="text"></th>
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

    public function testFilterPositionHeader(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr class="filters">
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[id]" type="text" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[name]" type="text"></th>
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

    public function testFilterRange(): void
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
            <th><input name="id" type="range" value="0"></th>
            <td>&nbsp;</td>
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
                ->columns($this->createDataColumnsWithFilterRange())
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
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[id]" type="text" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[name]" type="text"></th>
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

    public function testFilterSearch(): void
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
            <td>&nbsp;</td>
            <th><input name="name" type="search"></th>
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
                ->columns($this->createDataColumnsWithFilterSearch())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterSelect(): void
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
            <th><select name="searchModel[id]">
            <option>Select...</option>
            <option value="1">Jhon</option>
            <option value="2">Mary</option>
            </select></th>
            <td>&nbsp;</td>
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
                ->columns($this->createDataColumnsWithFilterSelect())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterTelephone(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Telephone</th>
            </tr>
            <tr class="text-center filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="searchModel[telephone]" type="tel"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="telephone">1 (555) 123-4567</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="telephone">1 (555) 123-4568</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterTelephone())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithTelephone, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterTime(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Time</th>
            </tr>
            <tr class="text-center filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="searchModel[time]" type="time"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="time">12:00:00</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="time">12:00:01</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterTime())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithTime, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterUrl(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Url</th>
            </tr>
            <tr class="text-center filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="searchModel[url]" type="url"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="url">&nbsp;</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="url">&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterUrl())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithTime, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testFilterWeek(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Week</th>
            </tr>
            <tr class="text-center filters">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th><input name="searchModel[week]" type="week"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="week">2000-W01</td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="week">2000-W02</td>
            </tr>
            </tbody>
            </table>
            <div>
            gridview.summary
            </div>
            </div>
            HTML,
            GridView::create()
                ->columns($this->createDataColumnsWithFilterWeek())
                ->filterModelName('searchModel')
                ->filterRowAttributes(['class' => 'text-center'])
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->dataWithWeek, 10, 1))
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
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[id]" type="text" value="0"></th>
            <th class="text-center" maxlength="5" style="width:60px"><input name="searchModel[name]" type="text"></th>
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

    private function createDataColumnsWithFilter(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filter('&nbsp;'),
            DataColumn::create()
                ->attribute('name')
                ->filter('<input name="searchModel[name]">'),
        ];
    }

    private function createDataColumnsWithFilterDate(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('birthday')
                ->filterAttribute('birthday')
                ->filterType('date'),
        ];
    }

    private function createDataColumnsWithFilterDateTime(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('birthday')
                ->filterAttribute('birthday')
                ->filterType('datetime'),
        ];
    }

    private function createDataColumnsWithFilterEmail(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('email')
                ->filterAttribute('email')
                ->filterType('email'),
        ];
    }

    private function createDataColumnsWithFilterInputAttributes(): array
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

    private function createDataColumnsWithFilterMonth(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('month')
                ->filterAttribute('month')
                ->filterType('month'),
        ];
    }

    private function createDataColumnsWithFilterNumber(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filterAttribute('id')
                ->filterType('number'),
            DataColumn::create()
                ->attribute('name'),
        ];
    }

    private function createDataColumnsWithFilterRange(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filterAttribute('id')
                ->filterType('range')
                ->filterValueDefault(0),
            DataColumn::create()
                ->attribute('name'),
        ];
    }

    private function createDataColumnsWithFilterSearch(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name')
                ->filterAttribute('name')
                ->filterType('search'),
        ];
    }

    private function createDataColumnsWithFilterSelect(): array
    {
        return [
            DataColumn::create()
                ->attribute('id')
                ->filterAttribute('id')
                ->filterInputSelectItems(['1' => 'Jhon', '2' => 'Mary'])
                ->filterInputSelectPrompt('Select...', 0)
                ->filterType('select'),
            DataColumn::create()
                ->attribute('name'),
        ];
    }

    private function createDataColumnsWithFilterTelephone(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('telephone')
                ->filterAttribute('telephone')
                ->filterType('tel'),
        ];
    }

    private function createDataColumnsWithFilterTime(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('time')
                ->filterAttribute('time')
                ->filterType('time'),
        ];
    }

    private function createDataColumnsWithFilterUrl(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('url')
                ->filterAttribute('url')
                ->filterType('url'),
        ];
    }

    private function createDataColumnsWithFilterWeek(): array
    {
        return [
            DataColumn::create()
                ->attribute('id'),
            DataColumn::create()
                ->attribute('name'),
            DataColumn::create()
                ->attribute('week')
                ->filterAttribute('week')
                ->filterType('week'),
        ];
    }

    private function createDataColumnsWithFilters(): array
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
}
