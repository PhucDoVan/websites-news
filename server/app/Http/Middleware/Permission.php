<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ApiException;
use App\Http\Logics\Api\PermissionLogic;

class Permission
{
    private PermissionLogic $permissionLogic;

    public function __construct(PermissionLogic $permissionLogic)
    {
        $this->permissionLogic = $permissionLogic;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $permissionType
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permissionType, $permission)
    {
        // if previous middleware check linkage_code is passed, no need to check permission
        if ($request->attributes->get('linkage_code')) {
            return $next($request);
        }

        $account = $request->attributes->get('account');
        if ( ! $account) {
            throw new ApiException(Response::HTTP_FORBIDDEN);
        }

        $roleIds       = $account->roles->pluck('id')->toArray();
        $hasPermission = $this->permissionLogic->checkPermission($roleIds, $permissionType, $permission);

        if ( ! $hasPermission) {
            throw new ApiException(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
