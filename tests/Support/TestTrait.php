<?php

declare(strict_types=1);

namespace Forge\GridView\Tests\Support;

use Yiisoft\Data\Paginator\OffSetPaginator;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Data\Reader\Iterable\IterableDataReader;

trait TestTrait
{
    private function createIterableProvider(array $data): IterableDataReader
    {
        return new IterableDataReader($data);
    }

    private function createPaginator(array $data, int $pageSize, int $currentPage): OffSetPaginator
    {
        $data = $this->createIterableProvider($data);

        return (new OffSetPaginator($data))->withPageSize($pageSize)->withCurrentPage($currentPage);
    }
}
