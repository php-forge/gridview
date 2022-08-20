<?php

declare(strict_types=1);

use Yiisoft\Aliases\Aliases;
use Yiisoft\Definitions\Reference;
use Yiisoft\Translator\CategorySource;
use Yiisoft\Translator\Message\Php\MessageSource;
use Yiisoft\Translator\MessageFormatterInterface;
use Yiisoft\Translator\Translator;
use Yiisoft\Translator\TranslatorInterface;

return [
    'translator.gridview' => static function (Aliases $aliases, MessageFormatterInterface $messageFormatter) {
        $messageReader = new MessageSource($aliases->get('@gridview/storage/message'));

        return new CategorySource('gridview', $messageReader, $messageFormatter);
    },
];
