<?php

namespace App\Http\Helpers;

use Illuminate\Validation\Rule;

/**
 * Class ValidateServiceHelper
 *
 * @package App\Http\Helpers
 */
class ValidateServiceHelper
{
    /**
     * Define validation rules for create new service
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getCreateServiceRules()
    {
        return [
            'name' => 'bail|required|max:100|unique:services,name',
        ];
    }

    /**
     * Define validation rules for edit service
     *
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getEditServiceRules()
    {
        return [
            'service_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('services', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

    /**
     * Define validation rules for update service
     *
     * @param $serviceId
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getUpdateServiceRules($serviceId)
    {
        return [
            'name' => [
                'bail',
                'required',
                'max:100',
                Rule::unique('services')->ignore($serviceId, 'id'),
            ]
        ];
    }

    /**
     * Define validation rules for delete service
     *
     * @return array
     */
    public static function getDeleteServiceRules()
    {
        return [
            'service_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('services')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }
}
