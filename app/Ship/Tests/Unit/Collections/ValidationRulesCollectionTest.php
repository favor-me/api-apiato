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

namespace App\Ship\Tests\Unit\Collections;

use App\Ship\Collections\ValidationRules;
use App\Ship\Tests\UnitTestCase;

class ValidationRulesCollectionTest extends UnitTestCase
{
    public function testHelperFunction(): void
    {
        $this->assertInstanceOf(ValidationRules::class, validation_rules(['nullable']));
    }

    public function testAddRequired()
    {
        $rules = new ValidationRules([
            'numeric'
        ]);

        $this->assertInstanceOf(ValidationRules::class, $rules->addRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'required'
        ]);

        $rules = new ValidationRules([
            'numeric',
            'required'
        ]);

        $this->assertInstanceOf(ValidationRules::class, $rules->addRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'required'
        ]);
    }

    public function testRemoveRequired(): void
    {
        $rules = new ValidationRules([
            'numeric',
            'nullable',
            'required'
        ]);

        $this->assertInstanceOf(ValidationRules::class, $rules->removeRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'nullable'
        ]);
    }

    public function testAddIgnoreIdForUnique(): void
    {
        $rules = new ValidationRules([
            'numeric',
            'unique:test_items,alias'
        ]);

        $newRules = $rules->addIgnoreIdForUnique(3);

        $this->assertInstanceOf(ValidationRules::class, $newRules);
        $this->assertArrayValues($newRules->toArray(), [
            'numeric',
            'unique:test_items,alias,3'
        ]);
    }

    public function testMixed(): void
    {
        $rules = new ValidationRules([
            'numeric',
            'unique:test_items,alias'
        ]);

        $rules = $rules
            ->addRequired()
            ->addIgnoreIdForUnique(4);

        $this->assertInstanceOf(ValidationRules::class, $rules);

        $this->assertArrayValues($rules->toArray(), [
            'required',
            'numeric',
            'unique:test_items,alias,4'
        ]);
    }

    public function testRemoveUnique(): void
    {
        $rules = new ValidationRules([
            'numeric',
            'unique:test_items,alias'
        ]);

        $rules = $rules->removeUnique();

        $this->assertInstanceOf(ValidationRules::class, $rules);

        $this->assertArrayValues($rules->toArray(), [
            'numeric'
        ]);
    }
}
