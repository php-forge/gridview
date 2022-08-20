<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

use Forge\Html\Helper\Attribute;
use Forge\Html\Tag\Tag;
use JsonException;
use Yiisoft\Json\Json;

/**
 * RadioButtonColumn displays a column of radio buttons in a grid view.
 */
final class RadioColumn extends Column
{
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
        $attributes['type'] = 'radio';

        if (!array_key_exists('name', $attributes)) {
            Attribute::add($attributes, 'name', 'radio-selection');
        }

        if (!array_key_exists('value', $attributes)) {
            /** @var mixed */
            Attribute::add($attributes, 'value', is_array($key) ? Json::encode($key) : $key);
        }

        return Tag::create('input', '', $attributes);
    }
}
