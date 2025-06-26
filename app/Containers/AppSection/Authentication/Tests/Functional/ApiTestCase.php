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

namespace App\Containers\AppSection\Authentication\Tests\Functional;

use App\Containers\AppSection\Authentication\Facades\Container;
use App\Containers\AppSection\Authentication\Tests\FunctionalTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

abstract class ApiTestCase extends FunctionalTestCase
{
    private bool $testingFilesCreated = false;
    private string $publicFilePath;
    private string $privateFilePath;

    public function setUp(): void
    {
        parent::setUp();

        $clientId = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create password grand client
        DB::table('oauth_clients')->insert([
            [
                'id' => $clientId,
                'secret' => $clientSecret,
                'name' => 'Testing',
                'redirect' => 'http://localhost',
                'password_client' => '1',
                'personal_access_client' => '0',
                'revoked' => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        Config::set('appSection-authentication.clients.web.id', $clientId);
        Config::set('appSection-authentication.clients.web.secret', $clientSecret);

        // create testing oauth keys files
        $this->publicFilePath = $this->createTestingKey('oauth-public.key');
        $this->privateFilePath = $this->createTestingKey('oauth-private.key');
    }

    private function createTestingKey($fileName): string
    {
        $filePath = storage_path($fileName);

        if (!file_exists($filePath)) {
            $keysStubDirectory = Container::getPath('Tests/Stubs');
            copy($keysStubDirectory . $fileName, $filePath);

            $this->testingFilesCreated = true;
        }

        return $filePath;
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($this->publicFilePath);
            unlink($this->privateFilePath);
        }
    }
}
