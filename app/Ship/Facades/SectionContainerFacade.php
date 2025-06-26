<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed trans(?string $key = null, array $replace = [], ?string $locale = null)
 * @method static string transFullKey(?string $key = null)
 * @method static string getApiBaseUrl()
 * @method static string getApiUri(?string $uri = null)
 * @method static mixed getConfig(?string $key = null)
 * @method static null|string getConfigName()
 * @method static string getName(bool $lcFirst = false)
 * @method static string getSectionName(bool $lcFirst = false)
 * @method static string getPath(?string $path = null)
 * @method static string transMultipleDeleted(int $count)
 * @method static string transMultipleRestored(int $count)
 * @method static string transMultipleTrashed(int $count)
 * @method static string transMultipleUpdated(int $count)
 * @method static string getBaseTranslatorNamespace()
 */
abstract class SectionContainerFacade extends Facade
{
}
