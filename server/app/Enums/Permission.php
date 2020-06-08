<?php
/**
 * Created by PhpStorm.
 * User: dttien.sgt
 * Date: 2020-04-19
 * Time: 18:33
 */

namespace App\Enums;

/**
 * Class Permission
 *
 * @package App\Enums
 */
class Permission
{
    public const TYPE_CORPORATION   = 'corporation';
    public const TYPE_GROUP         = 'group';
    public const TYPE_WHOLE_ACCOUNT = 'whole_account';
    public const TYPE_SELF_ACCOUNT  = 'self_account';
    public const TYPE_WHOLE_LOG     = 'whole_log';
    public const TYPE_SELF_LOG      = 'self_log';
    public const TYPE_WHOLE_BILL    = 'whole_bill';
    public const TYPE_SELF_BILL     = 'self_bill';
    public const TYPE_WHOLE_TOUKI   = 'whole_touki';
    public const TYPE_SELF_TOUKI    = 'self_touki';
    public const TYPE_CONTENT       = 'content';
    public const TYPE_ADMIN         = 'admin';

    public const EXECUTE = 'x';
    public const READ    = 'r';
    public const WRITE   = 'w';

    public const LEVEL
        = [
            0 => '---',
            1 => '--x',
            2 => '-w-',
            3 => '-wx',
            4 => 'r--',
            5 => 'r-x',
            6 => 'rw-',
            7 => 'rwx'
        ];
}
