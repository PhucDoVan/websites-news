<?php

namespace App\Http\Resources;

use App\Enums\Permission;
use App\Http\Helpers\PermissionHelper;
use App\Http\Logics\Api\PermissionLogic;
use App\Http\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class PermissionCollection extends ResourceCollection
{
    private Service         $service;
    private PermissionLogic $permissionLogic;

    /**
     * PermissionCollection constructor.
     *
     * @param Collection $resource A collection of permission models with permission_role
     * @param Service $service
     */
    public function __construct($resource, Service $service)
    {
        parent::__construct($resource);
        self::withoutWrapping();
        $this->service         = $service;
        $this->permissionLogic = resolve(PermissionLogic::class);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $accountPermissions = $this->collection;
        // FIXME: アカウントリソースのコレクションから呼ばれたときに、何度もSQLが走ってしまうので要改善
        $permissionNames    = $this->permissionLogic->getPermissionNamesByService($this->service);

        $permissions = [];
        foreach ($permissionNames as $permissionName) {
            $permission      = $accountPermissions->firstWhere('name', $permissionName);
            $permissionLevel = data_get($permission, 'permission_role.level', 0);

            $permissions[$permissionName] = [
                Permission::READ    => PermissionHelper::canRead($permissionLevel),
                Permission::WRITE   => PermissionHelper::canWrite($permissionLevel),
                Permission::EXECUTE => PermissionHelper::canExecute($permissionLevel),
            ];
        }
        return $permissions;
    }
}
