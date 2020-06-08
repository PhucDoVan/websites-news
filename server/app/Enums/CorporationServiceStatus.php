<?php
/**
 * Created by PhpStorm.
 * User: dttien.sgt
 * Date: 2020-04-14
 * Time: 18:33
 */

namespace App\Enums;

/**
 * Class CorporationServiceStatus
 *
 * @package App\Enums
 */
class CorporationServiceStatus
{
    public const INACTIVE   = 0;
    public const ACTIVE     = 1;
    public const RESTRICTED = 2;

    public const TERMINATED = 'terminated';

    public const LABEL
        = [
            self::INACTIVE   => '停止中',
            self::ACTIVE     => '利用中',
            self::RESTRICTED => '制限中',
            self::TERMINATED => '解約済',
        ];
}
