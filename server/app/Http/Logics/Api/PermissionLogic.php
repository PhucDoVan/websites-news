<?php

namespace App\Http\Logics\Api;

use App\Http\Helpers\PermissionHelper;
use App\Http\Models\Permission;
use App\Http\Models\PermissionRole;
use App\Http\Models\Service;

class PermissionLogic
{
    /**
     * Check if in list of role_id contain any role have a permission (r|w|x)
     * with permission type (permissions.name)
     *
     * @param array $roleIds
     * @param string $permissionType corporation|group|whole_account|...
     * @param string $permission r|w|x
     * @return bool
     */
    public function checkPermission($roleIds, $permissionType, $permission)
    {
        $levels          = PermissionHelper::getLevelsByPermission($permission);
        $permissionRoles = PermissionRole::join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->whereIn('permission_role.level', array_keys($levels))
            ->whereIn('permission_role.role_id', $roleIds)
            ->where('permissions.name', $permissionType)
            ->get();

        return ! $permissionRoles->isEmpty();
    }

    /**
     * Get the list of permission names by service.
     *
     * @param mixed $service App\Http\Models\Service instance or service id
     * @return mixed
     */
    public function getPermissionNamesByService($service)
    {
        $serviceId = $service instanceof Service ? $service->id : $service;
        return Permission::where('service_id', $serviceId)->pluck('name')->toArray();
    }
}
