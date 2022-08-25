<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\ActionColumn;
use Forge\GridView\Column\DataColumn;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\Html\Tag\Tag;
use Forge\TestUtils\Assert;
use Forge\TestUtils\Mock;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\Route;
use Yiisoft\Router\UrlGeneratorInterface;

final class ActionColumnTest extends TestCase
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
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="actions"><a class="text-decoration-none" href="/admin/view?id=1" title="View">&#128270;</a></td>
            </tr>
            <tr>
            <td data-label="actions"><a class="text-decoration-none" href="/admin/view?id=2" title="View">&#128270;</a></td>
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
                ->urlGenerator($this->createUrlGenerator())
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
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td class="text-decoration-none test.class" data-label="actions"><a href="/admin/view?id=1" title="View">&#128270;</a></td>
            </tr>
            <tr>
            <td class="text-decoration-none test.class" data-label="actions"><a href="/admin/view?id=2" title="View">&#128270;</a></td>
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
                ->urlGenerator($this->createUrlGenerator())
                ->render()
        );
    }

    public function testCustomButton(): void
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
            <a class="text-decoration-none" href="/admin/view?id=1" title="Resend password">&#128274;</a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a class="text-decoration-none" href="/admin/view?id=2" title="Resend password">&#128274;</a>
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
                ->columns($this->createColumnsWithButtonCustom())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
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
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="test.label">
            <a name="view" href="/admin/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="test.label">
            <a name="view" href="/admin/view?id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithDataLabel())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testFooterAttributes(): void
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
            <tfoot>
            <tr>
            <td class="test.class">test.footer</td>
            </tr>
            </tfoot>
            <tbody>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithFooterAttributes())
                ->footerEnabled(true)
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
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
            <th>test.label</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="test.label">
            <a name="view" href="/admin/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="test.label">
            <a name="view" href="/admin/view?id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithLabel())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
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
            </tr>
            </thead>
            <tbody>
            <tr>
            </tr>
            <tr>
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
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testPrimaryKey(): void
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
            <a name="view" href="/admin/view?identity_id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?identity_id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?identity_id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?identity_id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?identity_id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?identity_id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithPrimaryKey())
                ->id('w1-grid')
                ->paginator(
                    $this->createPaginator(
                        [
                            ['identity_id' => 1, 'name' => 'John', 'age' => 20],
                            ['identity_id' => 2, 'name' => 'Mary', 'age' => 21],
                        ],
                        10,
                        1,
                    )
                )
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
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
            <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td data-label="id">1</td>
            <td data-label="name">John</td>
            <td data-label="actions">
            <a name="view" href="/admin/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="id">2</td>
            <td data-label="name">Mary</td>
            <td data-label="actions">
            <a name="view" href="/admin/view?id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testUrlArguments(): void
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
            <a name="view" href="/admin/view?test-arguments=test.arguments&amp;id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-arguments=test.arguments&amp;id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-arguments=test.arguments&amp;id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?test-arguments=test.arguments&amp;id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-arguments=test.arguments&amp;id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-arguments=test.arguments&amp;id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithUrlArguments())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testUrlCreator(): void
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
            <a name="view" href="https://test.com/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="https://test.com/update?id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="https://test.com/delete?id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="https://test.com/view?id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="https://test.com/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="https://test.com/delete?id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithUrlCreator())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testUrlQueryParameters(): void
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
            <a name="view" href="/admin/view?test-param=test.param&amp;id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-param=test.param&amp;id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-param=test.param&amp;id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?test-param=test.param&amp;id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-param=test.param&amp;id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-param=test.param&amp;id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithUrlQueryParameters())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testUrlParamsConfig(): void
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
            <a name="view" href="/admin/view?test-param=test.param&amp;id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-param=test.param&amp;id=1" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-param=test.param&amp;id=1" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="view" href="/admin/view?test-param=test.param&amp;id=2" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            <a name="update" href="/admin/update?test-param=test.param&amp;id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
            <a name="delete" href="/admin/delete?test-param=test.param&amp;id=2" title="Delete" role="button" style="text-decoration: none!important;"><span>&#10060;</span></a>
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
                ->columns($this->createColumnsWithUrlParamsConfig())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    public function testVisibleButtonsClosure(): void
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
            <a name="view" href="/admin/view?id=1" title="View" role="button" style="text-decoration: none!important;"><span>&#128270;</span></a>
            </td>
            </tr>
            <tr>
            <td data-label="actions">
            <a name="update" href="/admin/update?id=2" title="Update" role="button" style="text-decoration: none!important;"><span>&#9998;</span></a>
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
                ->columns($this->createColumnsWithVisibleButtonsClosure())
                ->id('w1-grid')
                ->paginator($this->createPaginator($this->data, 10, 1))
                ->translator(Mock::translator('en'))
                ->urlGenerator($this->createUrlGenerator())
                ->urlName('admin')
                ->render()
        );
    }

    private function createColumns(): array
    {
        return [
            DataColumn::create()->attribute('id'),
            DataColumn::create()->attribute('name'),
            ActionColumn::create(),
        ];
    }

    private function createColumnsWithButtonCustom(): array
    {
        return [
            ActionColumn::create()
                ->buttons(
                    [
                        'resend-password' => static fn (string $url): string => Tag::a(
                            [
                                'class' => 'text-decoration-none',
                                'href' => $url,
                                'title' => 'Resend password',
                            ],
                            '&#128274;'
                        ),
                    ],
                )
                ->template('{resend-password}')
                ->visibleButtons(['resend-password' => true]),
        ];
    }

    private function createColumnsWithContent(): array
    {
        return [
            ActionColumn::create()
                ->content(
                    static fn (array|object $data, mixed $key, int $index): string => Tag::a(
                        [
                            'class' => 'text-decoration-none',
                            'href' => '/admin/view?id=' . $data['id'],
                            'title' => 'View',
                        ],
                        '&#128270;'
                    )
                ),
        ];
    }

    private function createColumnsWithContentAttributes(): array
    {
        return [
            ActionColumn::create()
                ->content(
                    static fn (array|object $data, mixed $key, int $index): string => Tag::a(
                        [
                            'href' => '/admin/view?id=' . $data['id'],
                            'title' => 'View',
                        ],
                        '&#128270;'
                    )
                )
                ->contentAttributes(['class' => 'text-decoration-none test.class'])
        ];
    }

    private function createColumnsWithDataLabel(): array
    {
        return [
            ActionColumn::create()->dataLabel('test.label'),
        ];
    }

    private function createColumnsWithFooterAttributes(): array
    {
        return [
            ActionColumn::create()
                ->footer('test.footer')
                ->footerAttributes(['class' => 'test.class']),
        ];
    }

    private function createColumnsWithLabel(): array
    {
        return [
            ActionColumn::create()->label('test.label'),
        ];
    }

    private function createColumnsWithNotVisible(): array
    {
        return [
            ActionColumn::create()->notVisible(),
        ];
    }

    private function createColumnsWithPrimaryKey(): array
    {
        return [
            ActionColumn::create()->primaryKey('identity_id'),
        ];
    }

    private function createColumnsWithUrlArguments(): array
    {
        return [
            ActionColumn::create()->urlArguments(['test-arguments' => 'test.arguments']),
        ];
    }

    private function createColumnsWithUrlCreator(): array
    {
        return [
            ActionColumn::create()
                ->urlCreator(
                    static fn (string $action, array|object $data, mixed $key, int $index): string => 'https://test.com/'
                    . $action . '?id=' . $data['id'],
                ),
        ];
    }

    private function createColumnsWithUrlQueryParameters(): array
    {
        return [
            ActionColumn::create()
                ->urlEnabledArguments(false)
                ->urlQueryParameters(['test-param' => 'test.param']),
        ];
    }

    private function createColumnsWithUrlParamsConfig(): array
    {
        return [
            ActionColumn::create()->urlParamsConfig(['test-param' => 'test.param']),
        ];
    }

    private function createColumnsWithVisibleButtonsClosure(): array
    {
        return [
            ActionColumn::create()->visibleButtons(
                [
                    'view' => static fn (array|object $data, mixed $key, int $index): bool => $data['id'] === 1
                        ? true : false,
                    'update' => static fn (array|object $data, mixed $key, int $index): bool => $data['id'] === 1
                        ? false : true,
                ],
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
                Route::get('/admin/view')->name('admin/resend-password'),
                Route::get('/admin/view')->name('admin/view'),
            ],
        );
    }
}
