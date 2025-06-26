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

use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Tests\UnitTestCase;

class ValidationRulesCollectionTest extends UnitTestCase
{
    public function testHelperFunction(): void
    {
        $this->assertInstanceOf(ValidationRulesCollection::class, validation_rules(['nullable']));
    }

    public function testAddRequired()
    {
        $rules = new ValidationRulesCollection([
            'numeric'
        ]);

        $this->assertInstanceOf(ValidationRulesCollection::class, $rules->addRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'required'
        ]);

        $rules = new ValidationRulesCollection([
            'numeric',
            'required'
        ]);

        $this->assertInstanceOf(ValidationRulesCollection::class, $rules->addRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'required'
        ]);
    }

    public function testRemoveRequired(): void
    {
        $rules = new ValidationRulesCollection([
            'numeric',
            'nullable',
            'required'
        ]);

        $this->assertInstanceOf(ValidationRulesCollection::class, $rules->removeRequired());
        $this->assertArrayValues($rules->toArray(), [
            'numeric',
            'nullable'
        ]);
    }

    public function testAddIgnoreIdForUnique(): void
    {
        $rules = new ValidationRulesCollection([
            'numeric',
            'unique:test_items,alias'
        ]);

        $newRules = $rules->addIgnoreIdForUnique(3);

        $this->assertInstanceOf(ValidationRulesCollection::class, $newRules);
        $this->assertArrayValues($newRules->toArray(), [
            'numeric',
            'unique:test_items,alias,3'
        ]);
    }

    public function testMixed(): void
    {
        $rules = new ValidationRulesCollection([
            'numeric',
            'unique:test_items,alias'
        ]);

        $rules = $rules
            ->addRequired()
            ->addIgnoreIdForUnique(4);

        $this->assertInstanceOf(ValidationRulesCollection::class, $rules);

        $this->assertArrayValues($rules->toArray(), [
            'required',
            'numeric',
            'unique:test_items,alias,4'
        ]);
    }

    public function testRemoveUnique(): void
    {
        $rules = new ValidationRulesCollection([
            'numeric',
            'unique:test_items,alias'
        ]);

        $rules = $rules->removeUnique();

        $this->assertInstanceOf(ValidationRulesCollection::class, $rules);

        $this->assertArrayValues($rules->toArray(), [
            'numeric'
        ]);
    }
}
