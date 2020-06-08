<?php


namespace App\Http\Logics\Api;

use App\Enums\RoleName;
use App\Enums\Service;

class RoleLogic
{
    public static function getRoleNameDefaultByService($serviceId)
    {
        $roleName = '';
        switch ($serviceId) {
            case Service::SHIKAKU_ID:
                $roleName = RoleName::SHIKAKUMAP_SUPER_USER;
                break;
        }
        return $roleName;
    }
}
