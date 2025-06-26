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

namespace App\Ship\Tests\Unit\Helpers\Classes;

use App\Ship\Helpers\Classes\Manager;
use App\Ship\Tests\UnitTestCase;
use Illuminate\Support\Facades\File;

class ManagerTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->helperPath = $this->createTestHelper('CustomTest');
        if (File::isFile($this->helperPath)) {
            $this->refreshApplication();
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();
        File::delete($this->helperPath);
    }

    public function testGetInstance(): void
    {
        $this->assertInstanceOf(Manager::class, app('helper'));
    }

    public function testGetLoaded(): void
    {
        $this->assertIsArray(app('helper')->getLoaded());
    }

    public function testHas(): void
    {
        $this->assertTrue(app('helper')->isLoaded('custom-test'));
        $this->assertFalse(app('helper')->isLoaded('no-found'));
    }

    private function createTestHelper(string $name): string
    {
        $dir = app_path('ship/Helpers/Classes');
        $fileName =  $name . 'Helper';

        $helperFile = $dir . '/' . $fileName . '.php';

        if (!File::isFile($helperFile)) {
            File::put($helperFile, $this->getHelperContent($fileName));
        }

        return $helperFile;
    }

    private function getHelperContent(string $fileName): string
    {
        $content = [
            '<?php',
            'namespace App\Ship\Helpers\Classes;',
            "class {$fileName} extends AppHelper",
            '{',
            '}'
        ];

        return implode(PHP_EOL, $content);
    }
}
