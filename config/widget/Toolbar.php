<?php

declare(strict_types=1);

return [
    'Toolbar' => [
        'containerLeftAttributes()' => [['class' => 'float-start mb-4 mt-3']],
        'containerRightAttributes()' => [['class' => 'float-end mb-4 mt-3']],
        'dropdownDefinition()' => [
            [
                'containerClass()' => ['btn-group'],
                'dividerClass()' => ['dropdown-divider'],
                'itemClass()' => ['dropdown-item'],
                'itemsContainerClass()' => ['dropdown-menu'],
                'toggleAttributes()' => [['aria-expanded' => 'false', 'data-bs-toggle' => 'dropdown']],
                'toggleClass()' => ['btn btn-ligth dropdown-toggle dropdown-toggle-split'],
                'splitButtonClass()' => ['btn btn-ligth'],
                'splitButtonSpanClass()' => ['visually-hidden'],
            ],
        ],
    ],
];
