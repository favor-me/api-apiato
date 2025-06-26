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

namespace App\Ship\Tests\Unit\Database\Eloquent\Concerns;

use App\Ship\Tests\Fackes\Models\HasCreatedByTestModel;
use App\Ship\Tests\UnitTestCase;

class HasCreatedByTest extends UnitTestCase
{
    public function testGetCreatedByColumn(): void
    {
        $this->assertSame('created_by', (new HasCreatedByTestModel)->getCreatedByColumn());
    }

    public function testSetCreatedBy(): void
    {
        $model = new HasCreatedByTestModel();
        $user  = $this->getTestingUser();

        $this->assertNull($model->created_by);
        $this->assertInstanceOf(HasCreatedByTestModel::class, $model->setCreatedBy($user->id));
        $this->assertIsInt($model->created_by);
    }

    public function testUpdateCreatedBy(): void
    {
        $this->getTestingUser();
        $model = new HasCreatedByTestModel();

        $this->assertNull($model->created_by);
        $model->updateCreatedBy();
        $this->assertIsInt($model->created_by);
    }
}
