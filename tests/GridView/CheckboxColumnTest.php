<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\CheckboxColumn;
use Forge\GridView\Column\DataColumn;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\Html\Tag\Tag;
use Forge\TestUtils\Assert;
use Forge\TestUtils\Mock;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\Route;

final class CheckboxColumnTest extends TestCase
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
            <th><input class="select-on-check-all" name="checkbox-selection-all" type="checkbox" value="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td><input name="checkbox-selection" type="checkbox" value="0"></td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
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
            <th><input class="select-on-check-all" name="checkbox-selection-all" type="checkbox" value="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td class="test.class"><input name="checkbox-selection" type="checkbox" value="0"></td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td class="test.class"><input name="checkbox-selection" type="checkbox" value="1"></td>
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
            <th><input class="select-on-check-all" name="checkbox-selection-all" type="checkbox" value="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="test.label"><input name="checkbox-selection" type="checkbox" value="0" data-label="test.label"></td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="test.label"><input name="checkbox-selection" type="checkbox" value="1" data-label="test.label"></td>
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

    public function testNotMultiple(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td><input name="checkbox-selection" type="checkbox" value="0"></td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
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
                ->columns($this->createColumnsWithNotMultiple())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator(Mock::urlGenerator([Route::get('/admin/manage')->name('admin/manage')]))
                ->render()
        );
    }

    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div id="w1-grid">
            <table class="table">
            <thead>
            <tr>
            <th>Id</th>
            <th>Name</th>
            <th><input class="select-on-check-all" name="checkbox-selection-all" type="checkbox" value="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td><input name="checkbox-selection" type="checkbox" value="0"></td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
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
                ->columns($this->createColumns())
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
            CheckboxColumn::create()
        ];
    }

    private function createColumnsWithContent(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            CheckboxColumn::create()->content(
                static fn (array|object $data, mixed $key, int $index): string => '<input name="checkbox-selection" type="checkbox" value="' . $index . '">'
            ),
        ];
    }

    private function createColumnsWithContentAttributes(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            CheckboxColumn::create()
                ->content(
                    static fn (array|object $data, mixed $key, int $index): string => '<input name="checkbox-selection" type="checkbox" value="' . $index . '">'
                )
                ->contentAttributes(['class' => 'test.class']),
        ];
    }

    private function createColumnsWithDataLabel(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            CheckboxColumn::create()->dataLabel('test.label'),
        ];
    }

    private function createColumnsWithNotMultiple(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            CheckboxColumn::create()->notMultiple(),
        ];
    }

    private function createColumnsWithNotVisible(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            CheckboxColumn::create()->notMultiple(),
        ];
    }
}