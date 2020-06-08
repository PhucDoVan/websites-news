<?php


namespace App\Http\Logics;

use App\Http\Models\Group;

class GroupLogic
{
    /**
     * Create group of corporation
     *
     * @param $parameters
     * @return bool
     */
    public function store($parameters)
    {
        $group = new Group($parameters);
        return $group->save();
    }

    /**
     * Update group
     *
     * @param $parameters
     * @return bool
     */
    public function update($parameters)
    {
        $group = Group::find($parameters['group_id']);
        $group->fill($parameters);
        return $group->save();
    }
}
