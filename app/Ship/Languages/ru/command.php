<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

// @codingStandardsIgnoreStart

return [
    'permissions:toSpecialistRole' => [
        'description' => 'Предоставлят все права для роли «Specialist»',
    ],
    'progress_bar_name' => 'Процес «:name» (Ожидайте! Или нажмите `Ctrl+C` для отмены)',
    'step_size' => 'Размер шага',
    'test' => [
        'description' => 'Тестирование компонентов проекта',
        'launch' => 'Запуск :component',
        'option' => [
            'all' => 'Тип тестирования <info>all</info>, <info>phpcs</info>, <info>phpmd</info>, <info>phpunit</info>',
            'component' => 'Компонент проекта <info>all</info>, <info>ship</info>, <info>sectionName</info>, <info>sectionName@containerName</info>',
        ],
        'phpunit' => [
            'no_tests' => 'Файлы PHP Unit тестирования не найдены',
        ],
        'process' => 'Обработка :component',
    ],
];
