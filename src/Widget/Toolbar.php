<?php

declare(strict_types=1);

namespace Forge\GridView\Widget;

use Forge\Html\Helper\CssClass;
use Forge\Html\Tag\Tag;
use Forge\Html\Widgets\Components\Button;
use Forge\Html\Widgets\Components\Select;
use Forge\Widget\AbstractWidget;
use ReflectionException;

final class Toolbar extends AbstractWidget
{
    private bool $containerLeft = true;
    private array $containerLeftAttributes = [];
    private bool $containerRight = true;
    private array $containerRightAttributes = [];
    private string $contentLeft = '';
    private string $contentRight = '';

    /**
     * Returns a new instance whether the toolbar is rendered in a container.
     *
     * @param bool $value Whether the toolbar is rendered in a container.
     *
     * @return self
     */
    public function containerLeft(bool $value): self
    {
        $new = clone $this;
        $new->containerLeft = $value;

        return $new;
    }

    /**
     * Return a new instance with the CSS class attributes for the container left.
     *
     * @param string $value The CSS class attributes for the container left.
     *
     * @return self
     */
    public function containerLeftClass(string $value): self
    {
        $new = clone $this;
        CssClass::add($new->containerLeftAttributes, $value);

        return $new;
    }

    /**
     * Returns a new instance with the HTML attributes for the container left.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function containerLeftAttributes(array $values): self
    {
        $new = clone $this;
        $new->containerLeftAttributes = $values;

        return $new;
    }

    /**
     * Return a new instance with the CSS class attributes for the container right.
     *
     * @param string $value The CSS class attributes for the container right.
     *
     * @return self
     */
    public function containerRightClass(string $value): self
    {
        $new = clone $this;
        CssClass::add($new->containerRightAttributes, $value);

        return $new;
    }
    /**
     * Returns a new instance with the HTML attributes for the container right.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     */
    public function containerRightAttributes(array $values): self
    {
        $new = clone $this;
        $new->containerRightAttributes = $values;

        return $new;
    }

    /**
     * Returns a new instance with the content of the container left.
     *
     * @param string $value The content of the container left.
     *
     * @return self
     */
    public function contentLeft(string $value): self
    {
        $new = clone $this;
        $new->contentLeft = $value;

        return $new;
    }

    /**
     * Returns a new instance with the content of the container right.
     *
     * @param string $value The content of the container right.
     *
     * @return self
     */
    public function contentRight(string $value): self
    {
        $new = clone $this;
        $new->contentRight = $value;

        return $new;
    }

    /**
     * @throws ReflectionException
     */
    public static function buttonApplyChanges(array $config = []): string
    {
        if ([] === $config) {
            $config = [
                'class()' => ['btn btn-success me-1'],
                'content()' => [Tag::i(['class' => 'bi bi-check-all'])],
                'id()' => ['btn-apply-changes'],
                'type()' => ['submit'],
            ];
        }

        return Button::create(config: $config)->render();
    }

    /**
     * @throws ReflectionException
     */
    public static function buttonCreateRecord(string $link, array $config = []): string
    {
        if ([] === $config) {
            $config = [
                'class()' => ['btn btn-primary me-1'],
                'content()' => [Tag::i(['class' => 'bi bi-plus'])],
                'type()' => ['link'],
            ];
        }

        return Button::create(config: $config)->link($link)->render();
    }

    /**
     * @throws ReflectionException
     */
    public static function buttonResetChanges(string $link, array $config = []): string
    {
        if ([] === $config) {
            $config = [
                'class()' => ['btn btn-dark me-1'],
                'content()' => [Tag::i(['class' => 'bi bi-bootstrap-reboot'])],
                'type()' => ['link'],
            ];
        }

        return Button::create(config: $config)->link($link)->render();
    }

    /**
     * Return selected page size.
     *
     * @param int $pageSize The page size paginator.
     * @param array $config The config select widget.
     *
     * @throws ReflectionException
     *
     * @return string
     */
    public static function selectPageSize(int $pageSize, array $config = []): string
    {
        if ([] === $config) {
            $config = [
                'class()' => ['form-select ms-3'],
                'id()' => ['pageSize'],
                'name()' => ['pageSize'],
                'items()' => [
                    [
                        '1' => '1',
                        '5' => '5',
                        '10' => '10',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                    ],
                ],
            ];
        }

        return Select::create(config: $config)->value($pageSize)->render();
    }

    protected function run(): string
    {
        return $this->renderLeft() . $this->renderRight();
    }

    private function renderLeft(): string
    {
        return match ($this->containerLeft) {
            true => Tag::div($this->containerLeftAttributes, $this->contentLeft),
            false => $this->contentLeft,
        };
    }

    private function renderRight(): string
    {
        return match ($this->containerRight) {
            true => Tag::div($this->containerRightAttributes, $this->contentRight),
            false => $this->contentRight,
        };
    }
}
