<?php

declare(strict_types=1);

namespace Forge\GridView;

use Closure;
use Forge\GridView\Column\Column;
use Forge\Html\Helper\Encode;
use Forge\Html\Tag\Tag;
use Forge\Widget\AbstractWidget;
use InvalidArgumentException;
use JsonException;
use Yiisoft\Translator\TranslatorInterface;

use function ucfirst;

/**
 * DetailView displays the detail of a single data.
 *
 * DetailView is best used for displaying a data in a regular format (e.g. each data attribute is displayed using
 * flexbox).
 *
 * The data can be either object or an associative array.
 *
 * DetailView uses the {@see dataAttributes} property to determines which model dataAttributes should be displayed
 * and how they should be formatted.
 *
 * A typical usage of DetailView is as follows:
 *
 * ```php
 * <?= DetailView::widget()->data($data) ?>
 * ```
 */
final class DetailView extends AbstractWidget
{
    private array $columns = [];
    private bool $columnsTranslation = true;
    private array $containerItemAttributes = [];
    private array $containerItemsAttributes = [];
    private array|Closure $labelAttributes = [];
    private string $labelTag = 'span';
    private array|object $data = [];
    private string $header = '';
    private TranslatorInterface|null $translator = null;
    private string $translatorCategory = '';
    private array|Closure $valueAttributes = [];
    private string $valueTag = 'div';

    /**
     * Return a new instance the specified columns.
     *
     * @param array $values The grid column configuration. Each array element represents the configuration for one
     * particular grid column. For example,
     *
     * ```php
     * [
     * ]
     * ```
     *
     * @return self
     */
    public function columns(array $values): self
    {
        $new = clone $this;
        $new->columns = $values;

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
     * Returns a new instance with the HTML attributes for the container item.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function containerItemAttributes(array $values): static
    {
        $new = clone $this;
        $new->containerItemAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes for the container items.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function containerItemsAttributes(array $values): static
    {
        $new = clone $this;
        $new->containerItemsAttributes = $values;

        return $new;
    }


    /**
     * Return new instance with the data.
     *
     * @param array|object $data the data model whose details are to be displayed. This can be a instance, an
     * associative array, an object.
     *
     * @return $this
     */
    public function data($data): self
    {
        $new = clone $this;
        $new->data = $data;

        return $new;
    }

    /**
     * return translator interface.
     */
    public function getTranslator(): TranslatorInterface
    {
        if ($this->translator === null) {
            throw new InvalidArgumentException('The translator is not set.');
        }

        return $this->translator;
    }

    /**
     * Return new instance with the header.
     *
     * @param string $value The header.
     *
     * @return self
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes for the label.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function labelAttributes(array $values): static
    {
        $new = clone $this;
        $new->labelAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the label tag.
     *
     * @param string $value The tag to use for the label.
     *
     * @return self
     */
    public function labelTag(string $value): self
    {
        $new = clone $this;
        $new->labelTag = $value;

        return $new;
    }

    /**
     * Returns a new instance with the translator interface of the grid view, detail view, or list view.
     *
     * @param TranslatorInterface $value The translator interface of the grid view, detail view, or list view.
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

    /**
     * Returns a new instance with the HTML attributes for the value.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     */
    public function valueAttributes(array $values): static
    {
        $new = clone $this;
        $new->valueAttributes = $values;

        return $new;
    }

    /**
     * Return new instance with the value tag.
     *
     * @param string $value The tag to use for the value.
     *
     * @return self
     */
    public function valueTag(string $value): self
    {
        $new = clone $this;
        $new->valueTag = $value;

        return $new;
    }

    protected function run(): string
    {
        return Tag::div($this->attributes, $this->renderItems());
    }

    private function has(string $attribute): bool
    {
        return is_array($this->data) ? array_key_exists($attribute, $this->data) : isset($this->data->$attribute);
    }

    /**
     * @psalm-return list<
     *     array{
     *         label: string,
     *         labelAttributes: array<array-key, mixed>,
     *         labelTag: string,
     *         value: string,
     *         valueAttributes: array<array-key, mixed>,
     *         valueTag: string
     *     }
     * >
     */
    private function normalizeColumns(array $columns): array
    {
        $normalized = [];

        /** @psalm-var array[] $columns */
        foreach ($columns as $value) {
            if (!isset($value['attribute']) && !isset($value['label'])) {
                throw new InvalidArgumentException('The "attribute" or "label" must be set.');
            }

            if (isset($value['attribute']) && !is_string($value['attribute'])) {
                throw new InvalidArgumentException('The "attribute" must be a string.');
            }

            if (isset($value['label']) && !is_string($value['label'])) {
                throw new InvalidArgumentException('The "label" must be a string.');
            }

            $attribute = $value['attribute'] ?? '';
            /** @var string */
            $label = $value['label'] ?? $value['attribute'];
            /** @var array|Closure */
            $labelAttributes = $value['labelAttributes'] ?? $this->labelAttributes;
            /** @var string */
            $labelTag = $value['labelTag'] ?? $this->labelTag;
            /** @var array|Closure */
            $valueAttributes = $value['valueAttributes'] ?? $this->valueAttributes;
            /** @var string */
            $valueTag = $value['valueTag'] ?? $this->valueTag;

            if ($this->columnsTranslation && '' !== $attribute) {
                $label = $this->getTranslator()->translate(
                    "detailview.column.$attribute",
                    [],
                    $this->translatorCategory,
                );
            }

            $normalized[] = [
                'label' => Encode::content($label),
                'labelAttributes' => $this->renderAttributes($labelAttributes),
                'labelTag' => Encode::content($labelTag),
                'value' => Encode::value($this->renderValue($attribute, $value['value'] ?? null)),
                'valueAttributes' => $this->renderAttributes($valueAttributes),
                'valueTag' => Encode::content($valueTag),
            ];
        }

        return $normalized;
    }

    private function renderAttributes(array|Closure $attributes): array
    {
        if ([] === $attributes) {
            return [];
        }

        if ($attributes instanceof Closure) {
            return (array) $attributes($this->data);
        }

        return $attributes;
    }

    private function renderItems(): string
    {
        $columns = $this->normalizeColumns($this->columns);
        $items = $this->header;

        foreach ($columns as $column) {
            $label = Tag::create($column['labelTag'], $column['label'], $column['labelAttributes']);
            $value = Tag::create($column['valueTag'], $column['value'], $column['valueAttributes']);

            $items .= Tag::div($this->containerItemAttributes, $label . $value);
        }

        return Tag::div($this->containerItemsAttributes, $items);
    }

    private function renderValue(string $attribute, mixed $value): mixed
    {
        if (null === $value && is_array($this->data) && $this->has($attribute)) {
            return $this->data[$attribute];
        }

        if (null === $value && is_object($this->data) && $this->has($attribute)) {
            return $this->data->{$attribute};
        }

        if ($value instanceof Closure) {
            return $value($this->data);
        }

        return $value;
    }
}