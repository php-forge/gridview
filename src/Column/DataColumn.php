<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

use Closure;
use Forge\Html\Helper\Attribute;
use Forge\Html\Helper\CssClass;
use Forge\Html\Helper\Encode;
use Forge\Html\Tag\Tag;
use Yiisoft\Arrays\ArrayHelper;

/**
 * DataColumn is the default column type for the {@see GridView} widget.
 *
 * It is used to show data columns and allows {@see sortingEnabled|sorting} and {@see filter|filtering} them.
 *
 * A simple data column definition refers to an attribute in the data of the GridView's data provider.
 *
 * The name of the attribute is specified by {@see attribute}.
 *
 * By setting {@see value} and {@see label}, the label and cell content can be customized.
 *
 * A data column differentiates between the {@see getDataCellValue|data cell value} and the
 * {@see renderDataCellContent|data cell content}. The cell value is an un-formatted value that may be used for
 * calculation, while the actual cell content is a {@see format|formatted} version of that value which may contain HTML
 * markup.
 */
final class DataColumn extends Column
{
    private string $attribute = '';
    private string $filter = '';
    private string $filterAttribute = '';
    private array $filterInputAttributes = [];
    private string $filterModelName = '';
    private mixed $filterValueDefault = null;
    private string $linkSorter = '';
    private bool $sortingEnabled = true;
    private mixed $value = null;

    /**
     * Return new instance with the attribute name.
     *
     * @param string $value The attribute name associated with this column. When neither {@see content} nor {@see value}
     * is specified, the value of the specified attribute will be retrieved from each data and displayed.
     *
     * Also, if {@see label} is not specified, the label associated with the attribute will be displayed.
     *
     * @return self
     */
    public function attribute(string $value): self
    {
        $new = clone $this;
        $new->attribute = $value;

        return $new;
    }

    /**
     * Return new instance with the filter input.
     *
     * @param string $value The HTML code representing a filter input (e.g. a text field, a dropdown list) that is
     * used for this data column. This property is effective only when {@see filterModel} is set.
     *
     * - If this property is not set, a text field will be generated as the filter input with attributes defined
     *   with {@see filterInputAttributes}.
     * - If this property is an array, a dropdown list will be generated that uses this property value as the list
     *   options.
     * - If you don't want a filter for this data column, set this value to be false.
     *
     * @return self
     */
    public function filter(string $value): self
    {
        $new = clone $this;
        $new->filter = $value;

        return $new;
    }

    /**
     * Return new instance with the filter attribute.
     *
     * @param string $value The attribute name of the {@see filterModel} associated with this column. If not set, will
     * have the same value as {@see attribute}.
     *
     * @return self
     */
    public function filterAttribute(string $value): self
    {
        $new = clone $this;
        $new->filterAttribute = $value;

        return $new;
    }

    /**
     * Return new instance with the HTML attributes for the filter input.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * This property is used in combination with the {@see filter} property. When {@see filter} is not set or is an
     * array, this property will be used to render the HTML attributes for the generated filter input fields.
     *
     * Empty `id` in the default value ensures that id would not be obtained from the data attribute thus
     * providing better performance.
     *
     * @return self
     */
    public function filterInputAttributes(array $values): self
    {
        $new = clone $this;
        $new->filterInputAttributes = $values;

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
     * Return new instance with set filter value default text input field.
     *
     * @param mixed $value The default value for the filter input field.
     *
     * @return self
     */
    public function filterValueDefault(mixed $value): self
    {
        $new = clone $this;
        $new->filterValueDefault = $value;

        return $new;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * Returns the data cell value.
     *
     * @param array|object $data The data.
     * @param mixed $key The key associated with the data.
     * @param int $index The zero-based index of the data in the data provider.
     *
     * @return string
     */
    public function getDataCellValue(array|object $data, mixed $key, int $index): string
    {
        $value = '';

        if ($this->value !== null && !($this->value instanceof Closure)) {
            $value = (string) $this->value;
        }

        if ($this->value instanceof Closure) {
            $value = (string) call_user_func($this->value, $data, $key, $index, $this);
        }

        if ($this->attribute !== '' && $this->value === null) {
            $value = (string) ArrayHelper::getValue($data, $this->attribute);
        }

        return $value === '' ? $this->getEmptyCell() : $value;
    }

    public function getLabel(): string
    {
        return parent::getLabel() !== '' ? parent::getLabel() : ucfirst($this->attribute);
    }

    /**
     * Return new instance with the link sorter.
     *
     * @param string $value The URL that will be used to sort the data in this column.
     *
     * @return self
     */
    public function linkSorter(string $value): self
    {
        $new = clone $this;
        $new->linkSorter = $value;

        return $new;
    }

    /**
     * Return new instance whether the column is not sortable.
     *
     * @return self
     */
    public function notSorting(): self
    {
        $new = clone $this;
        $new->sortingEnabled = false;

        return $new;
    }

    /**
     * Return new instance with the value of column.
     *
     * @param mixed $value An anonymous function or a string that is used to determine the value to
     * display in the current column.
     *
     * If this is an anonymous function, it will be called for each row and the return value will be used as the value
     * to display for every data. The signature of this function should be:
     *
     * `function ($data, $key, $index, $column)`.
     *
     * Where `$data`, `$key`, and `$index` refer to the data, key and index of the row currently being rendered
     * and `$column` is a reference to the {@see DataColumn} object.
     *
     * You may also set this property to a string representing the attribute name to be displayed in this column.
     *
     * This can be used when the attribute to be displayed is different from the {@see attribute} that is used for
     * sorting and filtering.
     *
     * If this is not set, `$data[$attribute]` will be used to obtain the value, where `$attribute` is the value of
     * {@see attribute}.
     *
     * @return self
     */
    public function value(mixed $value): self
    {
        $new = clone $this;
        $new->value = $value;

        return $new;
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
    protected function renderDataCellContent(object|array $data, mixed $key, int $index): string
    {
        if ($this->getContent() !== null) {
            return parent::renderDataCellContent($data, $key, $index);
        }

        return $this->getDataCellValue($data, $key, $index);
    }

    protected function renderFilterCellContent(): string
    {
        $filter = $this->filter !== '' ? $this->filter : parent::renderFilterCellContent();
        $filterInputAttributes = $this->filterInputAttributes;

        if ($this->filterAttribute !== '') {
            CssClass::add($filterInputAttributes, 'form-control');

            $name = Attribute::getInputName($this->filterModelName, $this->filterAttribute);

            Attribute::add($filterInputAttributes, 'name', $name);
            Attribute::add($filterInputAttributes, 'value', $this->filterValueDefault);

            $filter = Tag::create('input', '', $filterInputAttributes);
        }

        return $filter;
    }

    protected function renderHeaderCellContent(): string
    {
        $label = $this->getLabel() === ''
            ? Encode::content(parent::renderHeaderCellContent()) : Encode::content($this->getLabel());

        if ($this->attribute !== '' && $this->sortingEnabled && $this->linkSorter !== '') {
            $label = $this->linkSorter;
        }

        return $label;
    }
}
