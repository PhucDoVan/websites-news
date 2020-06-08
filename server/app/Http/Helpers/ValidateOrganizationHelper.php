<?php

namespace App\Http\Helpers;

use App\Enums\CorporationServiceStatus;
use App\Http\Rules\PostalCodeRule;
use Illuminate\Validation\Rule;

/**
 * Class ValidateOrganizationHelper
 *
 * @package App\Http\Helpers
 */
class ValidateOrganizationHelper
{
    /**
     * Define validation rules for create new organization
     *
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getCreateOrganizationRules()
    {
        return [
            'name'             => 'bail|required|max:100|unique:corporations,name',
            'kana'             => 'bail|nullable|max:100',
            'uid'              => [
                'bail',
                'required',
                'max:3',
                'regex:/^((?![1lIoO0])[a-zA-Z0-9]){3}$/',
                'unique:corporations'
            ],
            'postal_code'      => [
                'bail',
                'nullable',
                'max:50',
                new PostalCodeRule()
            ],
            'address_pref'     => 'bail|nullable|max:50',
            'address_city'     => 'bail|nullable|max:50',
            'address_town'     => 'bail|nullable|max:50',
            'address_building' => 'bail|nullable|max:50',
            'contact_name.*'   => 'bail|nullable|max:100',
            'contact_tel.*'    => 'bail|nullable|max:50',
            'contact_email.*'  => 'bail|nullable|max:250|email',
            'contact_fax.*'    => 'bail|nullable|max:50',
        ];
    }

    /**
     * Define validation rules for edit organization
     *
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getEditOrganizationRules()
    {
        return [
            'corporation_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('corporations')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

    /**
     * Define validation rules for update organization
     *
     * @param $organizationId
     * @author nvmanh.sgt@gmail.com
     * @return array
     */
    public static function getUpdateOrganizationRules($organizationId)
    {
        return [
            'name'             => [
                'bail',
                'required',
                'max:100',
                Rule::unique('corporations')->ignore($organizationId, 'corporation_id'),
            ],
            'kana'             => 'bail|nullable|max:100',
            'uid'              => [
                'bail',
                'required',
                'max:3',
                'regex:/^((?![1lIoO0])[a-zA-Z0-9]){3}$/',
                Rule::unique('corporations')->ignore($organizationId, 'corporation_id'),
            ],
            'postal_code'      => [
                'bail',
                'nullable',
                'max:50',
                new PostalCodeRule()
            ],
            'address_pref'     => 'bail|nullable|max:50',
            'address_city'     => 'bail|nullable|max:50',
            'address_town'     => 'bail|nullable|max:50',
            'address_building' => 'bail|nullable|max:50',
            'contact_name.*'   => 'bail|nullable|max:100',
            'contact_tel.*'    => 'bail|nullable|max:50',
            'contact_email.*'  => 'bail|nullable|max:250|email',
            'contact_fax.*'    => 'bail|nullable|max:50',
        ];
    }

    /**
     * Define validation rules for update corporation service status
     *
     * @return array
     */
    public static function getUpdateServiceStatusRules()
    {
        return [
            'service_id' => [
                'bail',
                'required',
                'integer',
                'exists:services,id,deleted_at,NULL',
            ],
            'status' => [
                'bail',
                'required',
                Rule::in([
                    CorporationServiceStatus::INACTIVE,
                    CorporationServiceStatus::ACTIVE,
                    CorporationServiceStatus::RESTRICTED,
                    CorporationServiceStatus::TERMINATED
                ])
            ]
        ];
    }

    /**
     * Define validation rules for delete organization
     *
     * @return array
     */
    public static function getDeleteOrganizationRules()
    {
        return [
            'corporation_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('corporations')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }
}
