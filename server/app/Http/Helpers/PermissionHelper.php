<?php

namespace App\Http\Helpers;

use App\Enums\Permission;
use Illuminate\Support\Str;

/**
 * Class PermissionHelper
 *
 * @package App\Http\Helpers
 */
class PermissionHelper
{
    /**
     * get list of level has a permission
     *
     * @param string $permission
     * @return array
     */
    public static function getLevelsByPermission(string $permission)
    {
        return array_filter(Permission::LEVEL, fn($string) => Str::contains($string, $permission));
    }

    /**
     * Whether or not it is an readable permission level.
     *
     * @param int|null $level
     * @return bool
     */
    public static function canRead(?int $level)
    {
        if ( ! key_exists($level, Permission::LEVEL)) {
            return false;
        }

        return Str::contains(Permission::LEVEL[$level], Permission::READ);
    }

    /**
     * Whether or not it is an writable permission level.
     *
     * @param int|null $level
     * @return bool
     */
    public static function canWrite(?int $level)
    {
        if ( ! key_exists($level, Permission::LEVEL)) {
            return false;
        }

        return Str::contains(Permission::LEVEL[$level], Permission::WRITE);
    }

    /**
     * Whether or not it is an executable permission level.
     *
     * @param int|null $level
     * @return bool
     */
    public static function canExecute(?int $level)
    {
        if ( ! key_exists($level, Permission::LEVEL)) {
            return false;
        }

        return Str::contains(Permission::LEVEL[$level], Permission::EXECUTE);
    }
}
