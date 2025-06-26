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

namespace App\Ship\Criterias;

use Illuminate\Database\Query\Builder;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisLikeThatCriteria
 *
 * @package App\Ship\Criterias
 */
class ThisLikeThatCriteria extends Criteria
{
    /**
     * Name of the column.
     *
     * @var string
     */
    private $field;

    /**
     * Contains values separated by $separator.
     *
     * @var string
     */
    private $valueString;

    /**
     * Separates separate items in the given $values string. Default is csv.
     *
     * @var string
     */
    private $separator;

    /**
     * This character is replaced with '%'. Default is *.
     *
     * @var string
     */
    private $wildcard;

    /**
     * ThisLikeThatCriteria constructor.
     *
     * @param   $field
     * @param   $valueString
     * @param   string $separator
     * @param   string $wildcard
     */
    public function __construct($field, $valueString, $separator = ',', $wildcard = '*')
    {
        $this->field = $field;
        $this->valueString = $valueString;
        $this->separator = $separator;
        $this->wildcard = $wildcard;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param   $model
     * @param   PrettusRepositoryInterface $repository
     *
     * @return  Builder
     *`
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)`
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $values = explode($this->separator, $this->valueString);
            $query->where($this->field, 'LIKE', str_replace($this->wildcard, '%', array_shift($values)));
            foreach ($values as $value) {
                $query->orWhere($this->field, 'LIKE', str_replace($this->wildcard, '%', $value));
            }
        });
    }
}
