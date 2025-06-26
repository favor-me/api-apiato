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

use App\Ship\Tests\Fackes\Models\HasUpdatedByTestModel;
use App\Ship\Tests\UnitTestCase;

class HasUpdatedByTest extends UnitTestCase
{
    public function testGetUpdatedByColumn(): void
    {
        $this->assertSame('updated_by', (new HasUpdatedByTestModel())->getUpdatedByColumn());
    }

    public function testSetCreatedBy(): void
    {
        $model = new HasUpdatedByTestModel();
        $user  = $this->getTestingUser();

        $this->assertNull($model->updated_by);
        $this->assertInstanceOf(HasUpdatedByTestModel::class, $model->setUpdatedBy($user->id));
        $this->assertIsInt($model->updated_by);
    }

    public function testUpdateCreatedBy(): void
    {
        $this->getTestingUser();
        $model = new HasUpdatedByTestModel();

        $this->assertNull($model->updated_by);
        $model->updateUpdatedBy();
        $this->assertIsInt($model->updated_by);
    }
}
