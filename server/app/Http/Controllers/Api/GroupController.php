<?php


namespace App\Http\Controllers\Api;

use App\Http\Logics\Api\GroupLogic;
use App\Http\Requests\Api\GroupRequest;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends BaseController
{
    public GroupLogic $groupLogic;

    public function __construct(GroupLogic $groupLogic)
    {
        $this->groupLogic = $groupLogic;
    }

    /**
     * Acquisition of department list by corporation id
     *
     * @param GroupRequest $request
     * @param $corporationId
     * @return AnonymousResourceCollection
     */
    public function getList(GroupRequest $request, $corporationId)
    {
        $groups = $this->groupLogic->getListByCorporationId($corporationId, $request->query());
        return GroupResource::collection($groups->appends($request->except('page')));
    }
}
