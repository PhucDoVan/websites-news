<?php

namespace App\Http\Helpers;


/**
 * Class ValidateGroupHelper
 *
 * @package App\Http\Helpers
 */
class ValidateGroupHelper
{
    public static function getCreateRules()
    {
        return [
            'corporation_id'  => 'bail|required|exists:corporations,corporation_id,deleted_at,NULL',
            'parent_group_id' => 'bail|nullable|exists:groups,id,deleted_at,NULL',
            'name'            => 'bail|required|max:100',
        ];
    }

    public static function getUpdateRules()
    {
        return [
            'group_id'        => 'bail|required|exists:groups,id,deleted_at,NULL',
            'parent_group_id' => 'bail|nullable|different:group_id|exists:groups,id,deleted_at,NULL',
            'name'            => 'bail|required|max:100',
        ];
    }
}
