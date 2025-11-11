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

namespace App\Ship\Parents\Tests;

use Apiato\Core\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use Apiato\Core\Exceptions\UndefinedMethodException;
use Apiato\Core\Traits\TestTraits\PhpUnit\TestRequestHelperTrait;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel as ApiatoConsoleKernel;
use Illuminate\Testing\TestResponse;
use JsonException;

/***
 * @property Generator $faker
 * @property null|UserModel $testingUser
 * @method mixed|UserModel getTestingUser(?array $userDetails = null, ?array $access = null, bool $createUserAsAdmin = false)
 */
abstract class TestCase extends AbstractTestCase
{
    use TestRequestHelperTrait;

    protected array $testData = [];

    public function createApplication()
    {
        //  This reads the value from `phpunit.xml` during testing.
        $this->baseUrl = env('API_FULL_URL');

        //  Override the default subDomain of the base URL when subDomain property is declared inside a test.
        $this->overrideSubDomain();

        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make(ApiatoConsoleKernel::class)->bootstrap();

        //  Create instance of faker and make it available in all tests.
        $this->faker = $app->make(Generator::class);

        return $app;
    }

    public function makeCall(array $data = [], array $headers = []): TestResponse
    {
        if (!array_key_exists('accept-language', $headers)) {
            $headers = array_merge($headers, [
                'accept-language' => $this->app->getLocale()
            ]);
        }

        return parent::makeCall($data, $headers);
    }

    public function makeCallNoAuth(array $data = [], array $headers = []): TestResponse
    {
        $endpoint = $this->parseEndpoint();
        $verb = $endpoint['verb'];
        $url = $endpoint['url'];

        switch ($verb) {
            case 'get':
                $url = $this->dataArrayToQueryParam($data, $url);
                break;
            case 'post':
            case 'put':
            case 'patch':
            case 'delete':
                break;
            default:
                throw new UndefinedMethodException('Unsupported HTTP Verb (' . $verb . ')!');
        }

        if (!array_key_exists('accept-language', $headers)) {
            $headers = array_merge($headers, [
                'accept-language' => $this->app->getLocale()
            ]);
        }

        $httpResponse = $this->json($verb, $url, $data, $headers);

        return $this->setResponseObjectAndContent($httpResponse);
    }

    public function withTestData(array $data = []): array
    {
        return array_replace_recursive($this->testData, $data);
    }

    public function decodeHashValue($value): string
    {
        return is_hash_id_mode() ? $this->decode($value) : $value;
    }

    public static function assertArrayValues(array $expected, array $actual): void
    {
        foreach ($actual as $field) {
            self::assertArrayHasValue($expected, $field);
        }
    }

    public static function assertArrayHasValue(array $array, $value): void
    {
        self::assertTrue(in_array($value, $array));
    }

    public function assertActionIsUnauthorized(): self
    {
        $this->response
            ->assertForbidden()
            ->assertJson([
                MESSAGE => __('ship::exception.unauthorized_action')
            ]);

        return $this;
    }

    public function assertGivenDataIsInvalid(): self
    {
        $this->response
            ->assertUnprocessable()
            ->assertJson([
                MESSAGE => __('ship::exception.given_data_was_invalid')
            ]);

        return $this;
    }

    /**
     * @param array $keys
     * @return void
     * @throws JsonException
     */
    public function assertNoValidationErrorContain(array $keys): void
    {
        $responseContent = $this->getResponseContentObject();
        $errorKeys = array_keys((array)$responseContent->errors);
        foreach ($keys as $key) {
            $this->assertFalse(in_array($key, $errorKeys));
        }
    }

    public function getTestingOrganizationOwnerUser(?array $userDetails = null, ?array $access = null): UserModel
    {
        return $this->getTestingOrganizationUser(array_merge((array)$userDetails, [
            User::IS_ORGANIZATION_OWNER => true
        ]), $access);
    }

    public function getTestingOrganizationUser(?array $userDetails = null, ?array $access = null): UserModel
    {
        $user = $this->getTestingUser($userDetails, $access);

        $organization = OrganizationModel::factory()
            ->create([
                Organization::USER_OWNER_ID => $user->id
            ]);

        $user->setAttribute(User::ORGANIZATION_ID, $organization->id);
        $user->update();

        return $user;
    }
}
