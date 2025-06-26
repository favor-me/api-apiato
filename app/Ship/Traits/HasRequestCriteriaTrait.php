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

namespace App\Ship\Traits;

use Apiato\Core\Abstracts\Repositories\Repository;
use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Ship\Criterias\RequestCriteria;
use Exception;
use Hashids\HashidsException;
use Prettus\Repository\Exceptions\RepositoryException;
use Vinkla\Hashids\Facades\Hashids;

trait HasRequestCriteriaTrait
{
    /**
     * @param null $repository
     * @param array $fieldsToDecode
     * @return $this
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function addRequestCriteria($repository = null, array $fieldsToDecode = ['id']): static
    {
        $validatedRepository = $this->validateRepository($repository);
        $validatedRepository->pushCriteria(app(RequestCriteria::class));

        if ($this->shouldDecodeSearch()) {
            $this->decodeSearchQueryString($fieldsToDecode);
        }

        return $this;
    }

    /**
     * @param null $repository
     * @return $this
     * @throws CoreInternalErrorException
     */
    public function removeRequestCriteria($repository = null): static
    {
        $validatedRepository = $this->validateRepository($repository);
        $validatedRepository->popCriteria(RequestCriteria::class);

        return $this;
    }

    private function arrayToSearchQuery(array $decodedSearchArray): string
    {
        $decodedSearchQuery = '';

        $fields = array_keys($decodedSearchArray);
        $length = count($fields);

        for ($i = 0; $i < $length; $i++) {
            $field = $fields[$i];
            $decodedSearchQuery .= "$field:$decodedSearchArray[$field]";
            if ($length !== 1 && $i < $length - 1) {
                $decodedSearchQuery .= ';';
            }
        }

        return $decodedSearchQuery;
    }

    private function checkDecodeField(string $field, string $value): void
    {
        if (empty(Hashids::decode($value))) {
            throw new HashidsException(__('ship::exception.only_hashed_id_allowed', [
                'field' => $field,
                'value' => $value
            ]));
        }
    }

    private function decodeData(array $fieldsToDecode, string $searchQuery): array
    {
        $searchArray = $this->parserSearchData($searchQuery);

        foreach ($fieldsToDecode as $field) {
            if (array_key_exists($field, $searchArray)) {
                $this->decodeField($field, $searchArray);
            }
        }

        return $searchArray;
    }

    private function decodeField(string $field, array &$searchArray): void
    {
        $decodeValues = [];
        $values = explode(',', $searchArray[$field]);
        foreach ($values as $value) {
            $this->checkDecodeField($field, $value);
            array_unshift($decodeValues, Hashids::decode($value)[0]);
        }

        $searchArray[$field] = implode(',', $decodeValues);
    }

    private function decodeSearchQueryString(array $fieldsToDecode): void
    {
        $query = request()->query();
        $searchQuery = $query['search'];
        $decodedValue = $this->decodeValue($searchQuery);
        $decodedData = $this->decodeData($fieldsToDecode, $searchQuery);
        $decodedQuery = $this->arrayToSearchQuery($decodedData);

        if ($decodedValue) {
            if (empty($decodedQuery)) {
                $decodedQuery .= $decodedValue;
            } else {
                $decodedQuery .= (';' . $decodedValue);
            }
        }

        $query['search'] = $decodedQuery;

        request()->query->replace($query);
    }

    private function decodeValue(string $searchQuery): ?string
    {
        $searchValue = $this->parserSearchValue($searchQuery);

        if ($searchValue) {
            $decodedId = Hashids::decode($searchValue);
            if ($decodedId) {
                return $decodedId[0];
            }
        }

        return $searchValue;
    }

    private function hashIdEnabled(): bool
    {
        return config('apiato.hash-id');
    }

    private function isSearching(array $query): bool
    {
        return array_key_exists('search', $query) && $query['search'];
    }

    private function parserSearchData($search): array
    {
        $searchData = [];

        if (strpos($search, ':')) {
            $fields = explode(';', $search);

            foreach ($fields as $row) {
                try {
                    [$field, $value] = explode(':', $row);
                    $searchData[$field] = $value;
                } catch (Exception $e) {
                    //  Surround offset error.
                }
            }
        }

        return $searchData;
    }

    private function parserSearchValue(string $search): ?string
    {
        if (strpos($search, ';') || strpos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                $s = explode(':', $value);
                if (count($s) === 1) {
                    return $s[0];
                }
            }

            return null;
        }

        return $search;
    }

    private function shouldDecodeSearch(): bool
    {
        return $this->hashIdEnabled() && $this->isSearching(request()->query());
    }

    /**
     * @param $repository
     * @return Repository
     * @throws CoreInternalErrorException
     */
    private function validateRepository($repository): Repository
    {
        $validatedRepository = $repository;

        //  Check if we have a "custom" repository.
        if (null === $repository) {
            if (!isset($this->repository)) {
                throw new CoreInternalErrorException(__('ship::exception.repository_no_exists'));
            }

            $validatedRepository = $this->repository;
        }

        //  Check, if the validated repository is null.
        if (null === $validatedRepository) {
            throw new CoreInternalErrorException();
        }

        //  Check if it is a Repository class.
        if (!($validatedRepository instanceof Repository)) {
            throw new CoreInternalErrorException();
        }

        return $validatedRepository;
    }
}
