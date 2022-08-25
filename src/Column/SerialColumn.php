<?php

declare(strict_types=1);

namespace Forge\GridView\Column;

/**
 * SerialColumn displays a column of row numbers (1-based).
 */
final class SerialColumn extends Column
{
    private int $offset = 0;

    public function getLabel(): string
    {
        return parent::getLabel() !== '' ? parent::getLabel() : '#';
    }

    /**
     * Return new instance with offset value of paginator.
     *
     * @param int $value Offset value of paginator.
     *
     * @return self
     */
    public function offset(int $value): self
    {
        $new = clone $this;
        $new->offset = $value;

        return $new;
    }

    /**
     * Renders the data cell content.
     *
     * @param array|object $data The data.
     * @param mixed $key The key associated with the data.
     * @param int $index The zero-based index of the data in the data provider. {@see GridView::dataProvider}.
     *
     * @return string the rendering result.
     */
    protected function renderDataCellContent(array|object $data, mixed $key, int $index): string
    {
        return (string) ($this->offset + $index + 1);
    }
}
