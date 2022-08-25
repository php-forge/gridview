<?php

declare(strict_types=1);

namespace Forge\GridView;

use Closure;
use Forge\GridView\Column\ActionColumn;
use Forge\GridView\Column\Column;
use Forge\GridView\Column\DataColumn;
use Forge\GridView\Column\SerialColumn;
use Forge\Html\Helper\CssClass;
use Forge\Html\Tag\Tag;
use InvalidArgumentException;
use ReflectionException;
use Yiisoft\Data\Paginator\OffsetPaginator;

/**
 * The GridView widget is used to display data in a grid.
 *
 * It provides features like {@see sorter|sorting}, and {@see filterModel|filtering} the data.
 *
 * The columns of the grid table are configured in terms of {@see Column} classes, which are configured via
 * {@see columns}.
 *
 * The look and feel of a grid view can be customized using the large amount of properties.
 */
final class GridView extends BaseListView
{
    public const FILTER_POS_HEADER = 'header';
    public const FILTER_POS_FOOTER = 'footer';
    public const FILTER_POS_BODY = 'body';
    private Closure|null $afterRow = null;
    private Closure|null $beforeRow = null;
    /** @psalm-var array<array-key,array<array-key,Column>|Column|string> */
    private array $columns = [];
    private bool $columnsGroupEnabled = false;
    private bool $columnsTranslation = false;
    private string $emptyCell = '&nbsp;';
    private string $filterModelName = '';
    private string $filterPosition = self::FILTER_POS_BODY;
    private array $filterRowAttributes = [];
    private bool $footerEnabled = false;
    private array $footerRowAttributes = [];
    private bool $headerTableEnabled = true;
    private array $headerRowAttributes = [];
    private array $rowAttributes = [];
    private array $tableAttributes = ['class' => 'table'];

    /**
     * Returns a new instance with anonymous function that is called once AFTER rendering each data.
     *
     * @param Closure|null $value The anonymous function that is called once AFTER rendering each data.
     *
     * @return self
     */
    public function afterRow(Closure|null $value): self
    {
        $new = clone $this;
        $new->afterRow = $value;

        return $new;
    }

    /**
     * Return a new instance with anonymous function that is called once BEFORE rendering each data.
     *
     * @param Closure|null $value The anonymous function that is called once BEFORE rendering each data.
     *
     * @return self
     */
    public function beforeRow(Closure|null $value): self
    {
        $new = clone $this;
        $new->beforeRow = $value;

        return $new;
    }

    /**
     * Return a new instance the specified columns.
     *
     * @param array $values The grid column configuration. Each array element represents the configuration for one
     * particular grid column. For example,
     *
     * ```php
     * [
     *     SerialColumn::create(),
     *     DataColumn::create()
     *         ->attribute('identity_id')
     *         ->filterAttribute('identity_id')
     *         ->filterValueDefault(0)
     *         ->filterAttributes(['class' => 'text-center', 'maxlength' => '5', 'style' => 'width:60px']),
     *     ActionColumn::create()->primaryKey('identity_id')->visibleButtons(['view' => true]),
     * ]
     * ```
     *
     * @return self
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $values
     */
    public function columns(array $values): self
    {
        $new = clone $this;
        $new->columns = $values;

        return $new;
    }

    /**
     * Returns a new instance with the specified column group enabled.
     *
     * @param bool $value Whether to enable the column group.
     *
     * @return self
     */
    public function columnsGroupEnabled(bool $value): self
    {
        $new = clone $this;
        $new->columnsGroupEnabled = $value;

        return $new;
    }

    /**
     * Returns a new instance whether to translate the grid column header.
     *
     * @param bool $value Whether to translate the grid column header.
     *
     * @return self
     */
    public function columnsTranslation(bool $value): self
    {
        $new = clone $this;
        $new->columnsTranslation = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML display when the content is empty.
     *
     * @param string $value The HTML display when the content of a cell is empty. This property is used to render cells
     * that have no defined content, e.g. empty footer or filter cells.
     *
     * @return self
     */
    public function emptyCell(string $value): self
    {
        $new = clone $this;
        $new->emptyCell = $value;

        return $new;
    }

    /**
     * Return new instance with the filter model name.
     *
     * @param string $value The form model name that keeps the user-entered filter data. When this property is set, the
     * grid view will enable column-based filtering. Each data column by default will display a text field at the top
     * that users can fill in to filter the data.
     *
     * Note that in order to show an input field for filtering, a column must have its {@see DataColumn::attribute}
     * property set and the attribute should be active in the current scenario of $filterModelName or have
     * {@see DataColumn::filter} set as the HTML code for the input field.
     *
     * @return self
     */
    public function filterModelName(string $value): self
    {
        $new = clone $this;
        $new->filterModelName = $value;

        return $new;
    }

    /**
     * Return new instance with the filter position.
     *
     * @param string $filterPosition Whether the filters should be displayed in the grid view. Valid values include:
     *
     * - {@see FILTER_POS_HEADER}: The filters will be displayed on top of each column's header cell.
     * - {@see FILTER_POS_BODY}: The filters will be displayed right below each column's header cell.
     * - {@see FILTER_POS_FOOTER}: The filters will be displayed below each column's footer cell.
     *
     * @return self
     */
    public function filterPosition(string $filterPosition): self
    {
        $new = clone $this;
        $new->filterPosition = $filterPosition;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes for filter row.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function filterRowAttributes(array $values): self
    {
        $new = clone $this;
        $new->filterRowAttributes = $values;

        return $new;
    }

    /**
     * Return new instance whether to show the footer section of the grid.
     *
     * @param bool $value Whether to show the footer section of the grid.
     *
     * @return self
     */
    public function footerEnabled(bool $value): self
    {
        $new = clone $this;
        $new->footerEnabled = $value;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes for footer row.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function footerRowAttributes(array $values): self
    {
        $new = clone $this;
        $new->footerRowAttributes = $values;

        return $new;
    }

    /**
     * Return new instance whether to show the header table section of the grid.
     *
     * @param bool $value Whether to show the header table section of the grid.
     *
     * @return self
     */
    public function headerTableEnabled(bool $value): self
    {
        $new = clone $this;
        $new->headerTableEnabled = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the header row.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function headerRowAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerRowAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for row of the grid.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * This can be either an array specifying the common HTML attributes for all body rows.
     *
     * @return self
     */
    public function rowAttributes(array $values): self
    {
        $new = clone $this;
        $new->rowAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the table.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function tableAttributes(array $values): self
    {
        $new = clone $this;
        $new->tableAttributes = $values;

        return $new;
    }

    /**
     * Renders the data active record classes for the grid view.
     *
     * @throws ReflectionException
     *
     * @return string
     */
    protected function renderItems(): string
    {
        $columns = $this->renderColumns();

        $content = array_filter([
            $this->columnsGroupEnabled ? $this->renderColumnGroup($columns) : false,
            $this->headerTableEnabled ? $this->renderTableHeader($columns) : false,
            $this->footerEnabled ? $this->renderTableFooter($columns) : false,
            $this->renderTableBody($columns),
        ]);

        return Tag::create('table', implode(PHP_EOL, $content), $this->tableAttributes);
    }

    protected function run(): string
    {
        if (null === $this->paginator) {
            throw new InvalidArgumentException('The "paginator" property must be set.');
        }

        return parent::run();
    }

    /**
     * This function tries to guess the columns to show from the given data if {@see columns} are not explicitly
     * specified.
     *
     * @psalm-return non-empty-list<ActionColumn|DataColumn>
     */
    private function guessColumns(): array
    {
        $columns = [];

        /** @psalm-var array[] */
        $dataReader = $this->getDataReader();
        reset($dataReader);

        foreach ($dataReader as $data) {
            /**
             * @var string $name
             * @var mixed $value
             */
            foreach ($data as $name => $value) {
                if (null === $value || is_scalar($value) || is_callable([$value, '__toString'])) {
                    $columns[] = DataColumn::create()->attribute($name);
                }
            }
            break;
        }

        $columns[] = ActionColumn::create();

        return $columns;
    }

    /**
     * Creates column objects and initializes them.
     *
     * @throws ReflectionException
     *
     * @psalm-return array<array-key,array<array-key,Column>|Column|string>
     */
    private function renderColumns(): array
    {
        $columns = $this->columns;
        /** @var OffsetPaginator */
        $paginator = $this->getPaginator();

        if ($columns === []) {
            $columns = $this->guessColumns();
        }

        foreach ($columns as $i => $column) {
            if ($column instanceof Column && !$column->isVisible()) {
                unset($columns[$i]);
                continue;
            }

            if ($column instanceof ActionColumn) {
                $column = $column
                    ->createDefaultButton()
                    ->urlGenerator($this->getUrlGenerator())
                    ->urlName($this->urlName);
            }

            if ($column instanceof Column) {
                $column = $column
                    ->columnsTranslation($this->columnsTranslation)
                    ->emptyCell($this->emptyCell)
                    ->translator($this->getTranslator())
                    ->translatorCategory($this->getTranslatorCategory());
            }

            if ($column instanceof DataColumn) {
                $linkSorter = $this->renderLinkSorter($column->getAttribute(), $column->getLabel());
                $column = $column->filterModelName($this->filterModelName);

                if ($linkSorter !== '') {
                    $column = $column->linkSorter($linkSorter);
                }
            }

            if ($column instanceof SerialColumn) {
                $column = $column->offset($paginator->getOffset());
            }

            $columns[$i] = $column;
        }

        return $columns;
    }

    /**
     * Renders the column group.
     *
     * @param array $columns The columns of gridview.
     *
     * @return string
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderColumnGroup(array $columns): string
    {
        $cols = [];

        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $cols[] = Tag::create('col', '', $column->getAttributes());
            }
        }

        return Tag::create('colgroup', implode(PHP_EOL, $cols));
    }

    /**
     * Renders the filter.
     *
     * @param array $columns The columns of gridview.
     *
     * @return string The rendering result.
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderFilters(array $columns): string
    {
        $cells = [];
        $filterRowAttributes = $this->filterRowAttributes;

        CssClass::add($filterRowAttributes, 'filters');

        foreach ($columns as $column) {
            if ($column instanceof DataColumn && ($column->getFilter() !== '' || $this->filterModelName !== '')) {
                $cells[] = $column->renderFilterCell() . PHP_EOL;
            }
        }

        return match ($cells) {
            [] => '',
            default => Tag::create('tr', trim(implode('', $cells)), $filterRowAttributes),
        };
    }

    /**
     * Renders the table body.
     *
     * @param array $columns The columns of gridview.
     *
     * @return string
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderTableBody(array $columns): string
    {
        $data = $this->getDataReader();
        $keys = array_keys($data);
        $rows = [];

        /** @psalm-var array<int,array> $data */
        foreach ($data as $index => $value) {
            $key = $keys[$index];

            if (null !== $this->beforeRow) {
                /** @var array */
                $row = call_user_func($this->beforeRow, $value, $key, $index, $this);

                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($columns, $value, $key, $index);

            if (null !== $this->afterRow) {
                /** @psalm-var array<array-key,string> */
                $row = call_user_func($this->afterRow, $value, $key, $index, $this);

                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }

        if ($rows === [] && $this->emptyText !== '') {
            $colspan = count($columns);
            $emptyText = $this->getTranslator()->translate($this->emptyText, [], 'gridview');

            return Tag::create(
                'tbody',
                Tag::create('tr', Tag::create('td', $emptyText, ['colspan' => $colspan])),
                []
            );
        }

        /** @psalm-var array<array-key,string> $rows */
        return Tag::create('tbody', implode(PHP_EOL, $rows), []);
    }

    /**
     * Renders the table footer.
     *
     * @param array $columns The columns of gridview.
     *
     * @return string
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderTableFooter(array $columns): string
    {
        $cells = [];
        $footerRowAttributes = $this->footerRowAttributes;

        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $cells[] = $column->renderFooterCell();
            }
        }

        $content = Tag::create('tr', implode('', $cells), $footerRowAttributes);

        if (self::FILTER_POS_FOOTER === $this->filterPosition) {
            $content .= PHP_EOL . $this->renderFilters($columns);
        }

        return Tag::create('tfoot', $content, []);
    }

    /**
     * Renders the table header.
     *
     * @param array $columns The columns of gridview.
     *
     * @return string
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderTableHeader(array $columns): string
    {
        $cells = [];

        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $cells[] = $column->renderHeaderCell() . PHP_EOL;
            }
        }

        $content = Tag::create('tr', trim(implode('', $cells)), $this->headerRowAttributes);
        $renderFilters =  PHP_EOL . $this->renderFilters($columns);

        if (self::FILTER_POS_HEADER === $this->filterPosition) {
            $content = $renderFilters . PHP_EOL . $content;
        } elseif (self::FILTER_POS_BODY === $this->filterPosition) {
            $content .= $renderFilters;
        }

        return Tag::create('thead', trim($content), []);
    }

    /**
     * Renders a table row with the given data and key.
     *
     * @param array $columns The columns of gridview.
     * @param array|object $data The data.
     * @param mixed $key The key associated with the data.
     * @param int $index The zero-based index of the data in the data provider.
     *
     * @return string
     *
     * @psalm-param array<array-key,array<array-key,Column>|Column|string> $columns
     */
    private function renderTableRow(array $columns, array|object $data, mixed $key, int $index): string
    {
        $cells = [];

        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $cells[] = $column->renderDataCell($data, $key, $index) . PHP_EOL;
            }
        }

        return Tag::create('tr', trim(implode('', $cells)), $this->rowAttributes);
    }
}
