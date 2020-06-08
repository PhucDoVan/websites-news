<?php

namespace Tests\Unit\Helpers;

use App\Http\Helpers\PermissionHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class PermissionHelperTest
 *
 * @package Tests\Unit\Helpers
 * @group helpers
 */
class PermissionHelperTest extends TestCase
{
    public function testCanRead()
    {
        $canReadLevels    = [4, 5, 6, 7];
        $canNotReadLevels = [0, 1, 2, 3, null];
        foreach ($canReadLevels as $level) {
            $this->assertTrue(PermissionHelper::canRead($level));
        }
        foreach ($canNotReadLevels as $level) {
            $this->assertFalse(PermissionHelper::canRead($level));
        }
    }

    public function testCanWrite()
    {
        $canWriteLevels    = [2, 3, 6, 7];
        $canNotWriteLevels = [0, 1, 4, 5, null];
        foreach ($canWriteLevels as $level) {
            $this->assertTrue(PermissionHelper::canWrite($level));
        }
        foreach ($canNotWriteLevels as $level) {
            $this->assertFalse(PermissionHelper::canWrite($level));
        }

    }

    public function testCanExecute()
    {
        $canExecuteLevels    = [1, 3, 5, 7];
        $canNotExecuteLevels = [0, 2, 4, 6, null];
        foreach ($canExecuteLevels as $level) {
            $this->assertTrue(PermissionHelper::canExecute($level));
        }
        foreach ($canNotExecuteLevels as $level) {
            $this->assertFalse(PermissionHelper::canExecute($level));
        }

    }
}
