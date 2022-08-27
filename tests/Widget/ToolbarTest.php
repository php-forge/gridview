<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\Widget;

use Forge\GridView\Widget\Toolbar;
use Forge\TestUtils\Assert;
use PHPUnit\Framework\TestCase;

final class ToolbarTest extends TestCase
{
    public function testRenderContentLeft(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div class="test.class.container.left" id="test.id.left">
            Content left
            </div>
            <div>
            </div>
            HTML,
            Toolbar::create()
                ->containerLeftAttributes(['id' => 'test.id.left'])
                ->containerLeftClass('test.class.container.left')
                ->contentLeft('Content left')
                ->render(),
        );
    }

    public function testRenderContentRigth(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <div>
            </div>
            <div class="test.class.container.right" id="test.id.right">
            Content right
            </div>
            HTML,
            Toolbar::create()
                ->containerRightAttributes(['id' => 'test.id.right'])
                ->containerRightClass('test.class.container.right')
                ->contentRight('Content right')
                ->render(),
        );
    }
}
