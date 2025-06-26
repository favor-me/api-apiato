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

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\Client\UI\API\Transformers\ClientTransformer;
use App\Containers\AppSection\Profile\UI\API\Transformers\ProfileTransformer;
use App\Containers\AppSection\Specialist\Foundation\Specialist;
use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\UI\API\Transformers\UserDeviceTransformer;
use App\Containers\LocationSection\City\UI\API\Transformers\CityTransformer;
use App\Containers\LocationSection\Country\UI\API\Transformers\CountryTransformer;
use App\Containers\LocationSection\Region\UI\API\Transformers\RegionTransformer;
use App\Containers\TelegramSection\Bot\UI\API\Transformers\TelegraphBotTransformer;
use App\Ship\Dto\CurrencyDto;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\SimpleTypes\Config\Money;
use Illuminate\Support\Str;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Primitive;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserTransformer extends Transformer
{
    public const INCLUDE_TELEGRAM_BOTS = 'telegramBots';

    protected array $availableIncludes = [
        'city',
        'roles',
        'region',
        'profile',
        'country',
        'contacts',
        'devices',
        'paramsSchema',
        self::INCLUDE_TELEGRAM_BOTS
    ];

    protected array $defaultIncludes = [
        'profile'
    ];

    public function transform(User $user): array
    {
        $object = $user->getResourceKey();

        $response = [
            OBJECT => $object,
            ID => $user->getHashedKey(),
            'login' => $user->login,
            'name' => $user->name,
            'patronymic' => $user->patronymic,
            'surname' => $user->surname,
            'gender' => $user->gender,
            'birth' => $this->timestampOrNull($user->birth),
            'avatar' => $user->avatar,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            PARAMS => $user->params,
            'email_verified_at' => $this->timestampOrNull($user->email_verified_at),
            'phone_number_verified_at' => $user->phone_number_verified_at,
            'country_id' => $user->getHashedKey('country_id'),
            'region_id' => $user->getHashedKey('region_id'),
            'city_id' => $user->getHashedKey('city_id'),
            'created_at' => $user->created_at->getTimestamp(),
            'updated_at' => $user->updated_at->getTimestamp(),
            'readable_created_at' => $user->created_at->diffForHumans(),
            'readable_updated_at' => $user->updated_at->diffForHumans()
        ];

        if ($user->hasRole(Role::SPECIALIST)) {
            $response = array_replace($response, [
                OBJECT => $object . Str::ucfirst(Role::SPECIALIST),
                Specialist::WEB_PAGE_URL => $user->getWebUrl()
            ]);
        }

        return $response;
    }

    protected function includeCity(User $user): Item|NullResource
    {
        return $this->nullOrItem($user->city, new CityTransformer());
    }

    protected function includeContacts(User $user): Collection
    {
        return $this->collection($user->contacts, new ClientTransformer());
    }

    protected function includeCountry(User $user): Item|NullResource
    {
        return $this->nullOrItem($user->country, new CountryTransformer());
    }

    protected function includeRegion(User $user): Item|NullResource
    {
        return $this->nullOrItem($user->region, new RegionTransformer());
    }

    protected function includeRoles(User $user): Collection
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    protected function includeDevices(User $user): Collection
    {
        return $this->collection($user->devices(), new UserDeviceTransformer());
    }

    protected function includeProfile(User $user): Item|NullResource
    {
        return $this->nullOrItem($user->profile, new ProfileTransformer());
    }

    /**
     * @param User $user
     * @return Primitive
     * @throws UnknownProperties
     */
    protected function includeParamsSchema(User $user): Primitive
    {
        return $this->primitive([
            $this->getCurrencyParamSchema($user),
            [
                'key' => BaseUser::PARAM_ENABLE_RESERVATION_FORM,
                'title' => Container::trans('params.' . BaseUser::PARAM_ENABLE_RESERVATION_FORM . '.title'),
                'hint' => Container::trans('params.' . BaseUser::PARAM_ENABLE_RESERVATION_FORM . '.hint'),
                'type' => 'boolean',
                'value' => $user->params->get(BaseUser::PARAM_ENABLE_RESERVATION_FORM, false)
            ]
        ]);
    }

    protected function includeTelegramBots(User $user): Collection
    {
        return $this->collection($user->telegramBots, new TelegraphBotTransformer());
    }

    /**
     * @param User $user
     * @return array
     * @throws UnknownProperties
     */
    protected function getCurrencyParamSchema(User $user): array
    {
        $currencyOptions = Money::getAllowedCurrencies()
            ->map(function (CurrencyDto $currency) {
                return [
                    'title' => $currency->title,
                    'value' => $currency->code
                ];
            });

        return [
            'key' => BaseUser::PARAM_CURRENCY,
            'title' => Container::trans('params.' . BaseUser::PARAM_CURRENCY . '.title'),
            'hint' => Container::trans('params.' . BaseUser::PARAM_CURRENCY . '.hint'),
            'type' => 'list',
            'value' => $user->params->get(BaseUser::PARAM_CURRENCY, config('money.default_currency')),
            'options' => $currencyOptions->toArray()
        ];
    }
}
