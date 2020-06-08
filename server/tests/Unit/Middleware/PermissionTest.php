<?php

namespace Tests\Unit\Middleware;

use App\Enums\Permission as PermissionEnum;
use App\Exceptions\ApiException;
use App\Http\Logics\Api\PermissionLogic;
use App\Http\Middleware\Permission;
use App\Http\Models\Account;
use App\Http\Models\ModelHasRoles;
use App\Http\Models\Permission as PermissionModel;
use App\Http\Models\PermissionRole;
use App\Http\Models\Role;
use App\Http\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\BaseTest;

/**
 * Class PermissionTest
 *
 * @package Tests\Unit\Middleware\PermissionTest
 * @group middleware
 */
class PermissionTest extends BaseTest
{
    public function testLinkageCodeOk()
    {
        $request = Request::create('/api/v1/test', 'GET');
        $request->attributes->add(['linkage_code' => 'linkage-code-valid']);
        $request->headers->set('X-LINKAGE-CODE', 'linkage-code-valid');
        $middleware = new Permission(new PermissionLogic);

        $response = $middleware->handle(
            $request,
            function () {
            },
            PermissionEnum::TYPE_ADMIN,
            PermissionEnum::READ
        );
        $this->assertNull($response);
    }

    public function testRequiredAccountLogIn()
    {
        $request    = Request::create('/api/v1/test', 'GET');
        $middleware = new Permission(new PermissionLogic);

        try {
            $middleware->handle(
                $request,
                function () {
                },
                PermissionEnum::TYPE_ADMIN,
                PermissionEnum::READ
            );
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_FORBIDDEN),
            $e
        );
    }

    public function testPermissionNG()
    {
        $account = factory(Account::class)->create();
        $service = factory(Service::class)->create();
        $role    = factory(Role::class)->create([
            'service_id' => $service->id
        ]);
        factory(ModelHasRoles::class)->create([
            'role_id'  => $role->id,
            'model_id' => $account->account_id
        ]);
        $permission = factory(PermissionModel::class)->create([
            'service_id' => $service->id
        ]);
        factory(PermissionRole::class)->create([
            'permission_id' => $permission->id,
            'role_id'       => $role->id,
            'level'         => 0
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->attributes->add(['account' => $account]);
        $middleware = new Permission(new PermissionLogic);

        try {
            $middleware->handle(
                $request,
                function () {
                },
                $permission->name,
                PermissionEnum::WRITE
            );
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_FORBIDDEN),
            $e
        );
    }

    public function testServiceTokenOK()
    {
        $account = factory(Account::class)->create();
        $service = factory(Service::class)->create();
        $role    = factory(Role::class)->create([
            'service_id' => $service->id
        ]);
        factory(ModelHasRoles::class)->create([
            'role_id'  => $role->id,
            'model_id' => $account->account_id
        ]);
        $permission = factory(PermissionModel::class)->create([
            'service_id' => $service->id
        ]);
        factory(PermissionRole::class)->create([
            'permission_id' => $permission->id,
            'role_id'       => $role->id,
            'level'         => 7
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->attributes->add(['account' => $account]);
        $middleware = new Permission(new PermissionLogic);

        $response = $middleware->handle(
            $request,
            function () {
            },
            $permission->name,
            PermissionEnum::WRITE
        );
        $this->assertNull($response);
    }
}
