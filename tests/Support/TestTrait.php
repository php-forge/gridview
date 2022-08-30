<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\Support;

use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Iterable\IterableDataReader;
use Yiisoft\Data\Reader\Sort;

trait TestTrait
{
    private function createIterableProvider(array $data): IterableDataReader
    {
        return new IterableDataReader($data);
    }

    private function createPaginator(array $data, int $pageSize, int $currentPage, bool $sort = false): OffSetPaginator
    {
        $data = $this->createIterableProvider($data);

        if ($sort) {
            $data = $data->withSort(Sort::any()->withOrder(['id' => 'asc', 'name' => 'asc']));
        }

        return (new OffsetPaginator($data))->withPageSize($pageSize)->withCurrentPage($currentPage);
    }
}
