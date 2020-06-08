<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends BaseController
{
    /**
     * Getting a list of roles by service
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $service = $request->attributes->get('service');
        $roles   = Role::where('service_id', optional($service)->id)->get();
        return RoleResource::collection($roles);
    }
}
