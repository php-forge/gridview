<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

use Forge\Html\Helper\Attribute;
use Forge\Html\Helper\CssClass;
use Forge\Html\Tag\Tag;
use JsonException;
use Yiisoft\Json\Json;

/**
 * CheckboxColumn displays a column of checkboxes in a grid view.
 */
final class CheckboxColumn extends Column
{
    private bool $multiple = true;

    /**
     * Return new instance with the multiple flag is set to false.
     *
     * @return self
     */
    public function notMultiple(): self
    {
        $new = clone $this;
        $new->multiple = false;

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
     *
     * @throws JsonException
     */
    protected function renderDataCellContent(array|object $data, mixed $key, int $index): string
    {
        if (!empty($this->getContent())) {
            return parent::renderDataCellContent($data, $key, $index);
        }

        $attributes = $this->getAttributes();

        if (!isset($attributes['value'])) {
            /** @var mixed */
            $attributes['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        if (!array_key_exists('name', $attributes)) {
            Attribute::add($attributes, 'name', 'checkbox-selection');
        }

        Attribute::add($attributes, 'type', 'checkbox');

        return Tag::create('input', '', $attributes);
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
        if ('' !== $this->getLabel() || false === $this->multiple) {
            return parent::renderHeaderCellContent();
        }

        $attributes = [];

        Attribute::add($attributes, 'name', $this->getArrayableName());
        Attribute::add($attributes, 'type', 'checkbox');
        Attribute::add($attributes, 'value', 1);
        CssClass::add($attributes, 'select-on-check-all');

        return Tag::create('input', '', $attributes);
    }

    private function getArrayableName(): string
    {
        $name = 'checkbox-selection';

        if (array_key_exists('name', $this->getAttributes())) {
            $name = (string) $this->getAttributes()['name'];
        }

        if (substr_compare($name, '[]', -2, 2) === 0) {
            $name = substr($name, 0, -2);
        }

        if (substr_compare($name, ']', -1, 1) === 0) {
            $name = substr($name, 0, -1) . '_all]';
        } else {
            $name .= '_all';
        }

        return $name;
    }
}
