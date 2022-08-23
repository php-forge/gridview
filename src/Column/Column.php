<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

use Closure;
use Forge\GridView\GridView;
use Forge\Html\Helper\Attribute;
use Forge\Html\Helper\CssClass;
use Forge\Html\Tag\Tag;
use Yiisoft\Translator\TranslatorInterface;

use function strtolower;

/**
 * Column is the base class of all {@see GridView} column classes.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
abstract class Column
{
    private array $attributes = [];
    private bool $columnsTranslation = false;
    private Closure|null $content = null;
    private array $contentAttributes = [];
    private string $emptyCell = '';
    private array $filterAttributes = [];
    private string $footer = '';
    private array $footerAttributes = [];
    private string $label = '';
    private array $labelAttributes = [];
    private TranslatorInterface $translator;
    private string $translatorCategory = '';
    protected bool $visible = true;

    final public function __construct()
    {
    }

    /**
     * Return new instance with the HTML attributes of column.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function attributes(array $values): static
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Returns a new instance whether to translate the grid column header.
     *
     * @param bool $value Whether to translate the grid column header.
     *
     * @return static
     */
    public function columnsTranslation(bool $value): static
    {
        $new = clone $this;
        $new->columnsTranslation = $value;

        return $new;
    }

    /**
     * Return new instance with the column content.
     *
     * @param Closure $value This is a callable that will be used to generate the content.
     *
     * The signature of the function should be the following: `function ($data, $key, $index, $column)`.
     *
     * Where `$data`, `$key`, and `$index` refer to the data, key and index of the row currently being rendered
     * and `$column` is a reference to the {@see Column} object.
     *
     * @return static
     */
    public function content(Closure $value): static
    {
        $new = clone $this;
        $new->content = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the column content.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function contentAttributes(array $values): static
    {
        $new = clone $this;
        $new->contentAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the data label for the column content.
     *
     * @param string $value The data label for the column content.
     *
     * @return static
     */
    public function dataLabel(string $value): static
    {
        $new = clone $this;
        Attribute::add($new->contentAttributes, 'data-label', $value);

        return $new;
    }

    /**
     * Return new instance with the HTML display when the content is empty.
     *
     * @param string $value The HTML display when the content of a cell is empty. This property is used to render cells
     * that have no defined content, e.g. empty footer or filter cells.
     *
     * @return static
     */
    public function emptyCell(string $value): static
    {
        $new = clone $this;
        $new->emptyCell = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the filter cell.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function filterAttributes(array $values): static
    {
        $new = clone $this;
        $new->filterAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the footer content.
     *
     * @param string $value The footer content.
     *
     * @return static
     */
    public function footer(string $value): static
    {
        $new = clone $this;
        $new->footer = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the footer cell.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function footerAttributes(array $value): static
    {
        $new = clone $this;
        $new->footerAttributes = $value;

        return $new;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getColumnsTranslation(): bool
    {
        return $this->columnsTranslation;
    }

    public function getContent(): ?Closure
    {
        return $this->content;
    }

    public function getContentAttributes(): array
    {
        return $this->contentAttributes;
    }

    public function getEmptyCell(): string
    {
        return $this->emptyCell;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    public function getTranslatorCategory(): string
    {
        return $this->translatorCategory;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * Return new instance with the label for the column.
     *
     * @param string $value The label to be displayed in the {@see header|header cell} and also to be used as the
     * sorting link label when sorting is enabled for this column.
     *
     * If it is not set and the active record classes provided by the GridViews data provider are instances of the
     * object data, the label will be determined using Otherwise {@see Inflector::toHumanReadable()} will be used to
     * get a label.
     *
     * @return static
     */
    public function label(string $value): static
    {
        $new = clone $this;
        $new->label = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the header cell.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function labelAttributes(array $value): static
    {
        $new = clone $this;
        $new->labelAttributes = $value;

        return $new;
    }

    /**
     * Return new instance with the name of the column.
     *
     * @param string $value The name of the column.
     *
     * @return static
     */
    public function name(string $value): static
    {
        $new = clone $this;
        Attribute::add($new->attributes, 'name', $value);

        return $new;
    }

    /**
     * Return new instance specifying whether the column is not visible.
     *
     * @return static
     */
    public function notVisible(): static
    {
        $new = clone $this;
        $new->visible = false;

        return $new;
    }

    /**
     * Renders a data cell.
     *
     * @param array|object $data The data.
     * @param mixed $key The key associated with the data.
     * @param int $index The zero-based index of the data in the data provider.
     *
     * @return string
     */
    public function renderDataCell(array|object $data, mixed $key, int $index): string
    {
        $contentAttributes = $this->contentAttributes;

        if (!array_key_exists('data-label', $contentAttributes)) {
            Attribute::add($contentAttributes, 'data-label', strtolower($this->getLabel()));
        }

        return Tag::create('td', $this->renderDataCellContent($data, $key, $index), $contentAttributes);
    }

    /**
     * Renders the filter cell.
     */
    public function renderFilterCell(): string
    {
        return Tag::create('th', $this->renderFilterCellContent(), $this->filterAttributes);
    }

    /**
     * Renders the footer cell.
     */
    public function renderFooterCell(): string
    {
        return Tag::create('td', $this->renderFooterCellContent(), $this->footerAttributes);
    }

    /**
     * Renders the header cell.
     */
    public function renderHeaderCell(): string
    {
        return Tag::create('th', $this->renderHeaderCellContent(), $this->labelAttributes);
    }

    /**
     * Returns a new instance with the translator interface.
     *
     * @param TranslatorInterface $value The translator interface.
     *
     * @return static
     */
    public function translator(TranslatorInterface $value): static
    {
        $new = clone $this;
        $new->translator = $value;

        return $new;
    }

    /**
     * Returns a new instance with the translator category.
     *
     * @param string $value The translator category.
     *
     * @return static
     */
    public function translatorCategory(string $value): static
    {
        $new = clone $this;
        $new->translatorCategory = $value;

        return $new;
    }

    public static function create(): static
    {
        return new static();
    }

    /**
     * Returns header cell label.
     *
     * This method may be overridden to customize the label of the header cell.
     *
     * @return string
     */
    protected function getHeaderCellLabel(): string
    {
        return $this->emptyCell;
    }

    /**
     * Renders the data cell content.
     *
     * @param array|object $data The data.
     * @param mixed $key The key associated with the data.
     * @param int $index The zero-based index of the data in the data provider.
     *
     * @return string
     */
    protected function renderDataCellContent(array|object $data, mixed $key, int $index): string
    {
        $html = $this->emptyCell;

        if ($this->content !== null) {
            $html = (string) call_user_func($this->content, $data, $key, $index, $this);
        }

        return $html;
    }

    /**
     * Renders the filter cell content.
     *
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     *
     * @return string
     */
    protected function renderFilterCellContent(): string
    {
        return $this->emptyCell;
    }

    /**
     * Renders the footer cell content.
     *
     * The default implementation simply renders {@see footer}.
     * This method may be overridden to customize the rendering of the footer cell.
     *
     * @return string
     */
    protected function renderFooterCellContent(): string
    {
        return trim($this->footer) !== '' ? $this->footer : $this->emptyCell;
    }

    /**
     * Renders the header cell content.
     *
     * The default implementation simply renders {@see header}.
     * This method may be overridden to customize the rendering of the header cell.
     *
     * @return string
     */
    protected function renderHeaderCellContent(): string
    {
        return '' !== $this->getLabel() ? $this->getLabel() : $this->getHeaderCellLabel();
    }
}
