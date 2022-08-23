<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

use Forge\Html\Helper\Attribute;
use Forge\Html\Helper\CssClass;
use Forge\Html\Helper\Utils;
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
        if ($this->getContent() !== null) {
            return parent::renderDataCellContent($data, $key, $index);
        }

        $contentAttributes = $this->getContentAttributes();

        if (!isset($contentAttributes['value'])) {
            /** @var mixed */
            $contentAttributes['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        if (!array_key_exists('name', $contentAttributes)) {
            Attribute::add($contentAttributes, 'name', 'checkbox-selection');
        }

        Attribute::add($contentAttributes, 'type', 'checkbox');

        return Tag::create('input', '', $contentAttributes);
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
        if ($this->getLabel() !== '' || $this->multiple === false) {
            return parent::renderHeaderCellContent();
        }

        $headerCellattributes = [];

        Attribute::add($headerCellattributes, 'name', 'checkbox-selection-all');
        Attribute::add($headerCellattributes, 'type', 'checkbox');
        Attribute::add($headerCellattributes, 'value', 1);
        CssClass::add($headerCellattributes, 'select-on-check-all');

        return Tag::create('input', '', $headerCellattributes);
    }
}
