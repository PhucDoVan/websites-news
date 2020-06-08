<?php

namespace App\Http\Helpers;

use Illuminate\Validation\Rule;
use App\Http\Rules\AdminPasswordRule;

class ValidateAdminHelper
{
    /**
     * Define validation rules for store manager
     *
     * @return array
     */
    public static function getStoreRules()
    {
        return [
            'name'     => 'bail|required|max:50|unique:managers',
            'username' => 'bail|required|max:50|unique:managers',
            'password' => [
                'bail',
                'required',
                'max:50',
                'min:10',
                'alpha_num',
                new AdminPasswordRule(),
            ]
        ];
    }

    /**
     * Define validation rules for edit manager
     *
     * @return array
     */
    public static function getEditRules()
    {
        return [
            'manager_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('managers')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

    /**
     * Define validation rules for store manager
     *
     * @param $managerId
     * @return array
     */
    public static function getUpdateRules($managerId)
    {
        return [
            'name'     => [
                'bail',
                'required',
                'max:50',
                Rule::unique('managers')->ignore($managerId, 'manager_id'),
            ],
            'username' => [
                'bail',
                'required',
                'max:50',
                Rule::unique('managers')->ignore($managerId, 'manager_id'),
            ],
            'password' => [
                'bail',
                'nullable',
                'max:50',
                'min:10',
                'alpha_num',
                new AdminPasswordRule(),
            ]
        ];
    }

    /**
     * Define validation rules for delete manager
     *
     * @return array
     */
    public static function getDeleteRules()
    {
        return [
            'manager_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('managers')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

}
