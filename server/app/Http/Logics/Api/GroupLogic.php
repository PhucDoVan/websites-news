<?php


namespace App\Http\Logics\Api;

use App\Http\Models\Group;
use Illuminate\Support\Arr;

class GroupLogic
{
    /**
     * Constant
     */
    public const GROUP_NAME_DEFAULT = 'デフォルト';

    /**
     * Create a department of corporation
     *
     * @param $parameters
     * @return Group
     */
    public function store($parameters)
    {
        $group = new Group($parameters);
        $group->save();

        return $group;
    }

    /**
     * Get list department by corporation ID
     *
     * @param $corporationId
     * @param array $options
     * @return mixed
     */
    public function getListByCorporationId($corporationId, array $options = [])
    {
        $limit         = Arr::get($options, 'limit') ?? config('api.limit_per_page');
        $parentGroupId = Arr::get($options, 'parent_group_id');
        $groupIds      = Arr::get($options, 'group_ids');

        $groups = Group::where('corporation_id', $corporationId);

        if ($parentGroupId) {
            $groups->where('parent_group_id', $parentGroupId);
        }
        if ($groupIds) {
            $groups->whereIn('id', explode(',', $groupIds));
        }

        return $groups->paginate($limit);
    }
}
