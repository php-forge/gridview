<?php

declare(strict_types=1);

namespace Forge\GridView\Widget;

use Forge\Html\Tag\Tag;
use Forge\Widget\AbstractWidget;
use Yiisoft\Translator\TranslatorInterface;

final class Summary extends AbstractWidget
{
    public function __construct(
        private int $begin,
        private int $count,
        private int $page,
        private int $pageCount,
        private string $summary,
        private array $summaryAttributes,
        private int $totalCount,
        private TranslatorInterface $translator
    ) {
        parent::__construct();
    }

    protected function run(): string
    {
        if (0 >= $this->count) {
            return '';
        }

        $end = ($this->begin + $this->totalCount) - 1;

        return Tag::div(
            $this->summaryAttributes,
            $this->translator
                ->translate(
                    $this->summary,
                    [
                        'begin' => $this->begin,
                        'end' => $end,
                        'count' => $this->count,
                        'totalCount' => $this->count,
                        'page' => $this->page,
                        'pageCount' => $this->pageCount,
                    ],
                    'gridview',
                )
        );
    }
}
