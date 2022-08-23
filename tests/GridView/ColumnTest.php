<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\GridView;

use Forge\GridView\Column\Column;
use Forge\GridView\GridView;
use Forge\GridView\Tests\Support\TestTrait;
use Forge\Html\Tag\Tag;
use Forge\TestUtils\Assert;
use Forge\TestUtils\Mock;
use PHPUnit\Framework\TestCase;
use Yiisoft\Router\Route;

final class ColumnTest extends TestCase
{
    use TestTrait;

    private array $data = [
        ['id' => 1, 'name' => 'John', 'age' => 20],
        ['id' => 2, 'name' => 'Mary', 'age' => 21],
    ];

    private function createColumnClass(): Column
    {
        return new class extends Column {
        };
    }
}
