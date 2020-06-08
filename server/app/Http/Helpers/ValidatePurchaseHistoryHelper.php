<?php

namespace App\Http\Helpers;

/**
 * Class ValidatePurchaseHistory
 *
 * @package App\Http\Helpers
 */
class ValidatePurchaseHistoryHelper
{
    /**
     * Define validation rules for record function
     *
     * @param $authType
     * @return array
     */
    public static function getApiRecordRules($authType)
    {
        return [
            'account_id'    => ValidatePurchaseHistoryHelper::getAccountIdRule($authType),
            'password'      => 'bail|required_if:auth_type,1|max:50',
            'auth_type'     => 'bail|required|numeric',
            'service_id'    => 'bail|required|numeric|digits_between:1,19',
            'content_ids'   => 'bail|required|array',
            'content_ids.*' => 'bail|required|numeric|digits_between:1,19|distinct',
        ];
    }

    /**
     * Define validation rules for reference function
     *
     * @param $authType
     * @return array
     */
    public static function getApiReferenceRules($authType)
    {
        return [
            'account_id'            => ValidatePurchaseHistoryHelper::getAccountIdRule($authType),
            'password'              => 'bail|required_if:auth_type,1|max:50',
            'auth_type'             => 'bail|required|numeric',
            'service_id'            => 'bail|required|numeric|digits_between:1,19',
            'registered_date_begin' => 'bail|nullable|date|date_format:Ymd',
            'registered_date_end'   => 'bail|nullable|date|date_format:Ymd|after_or_equal:registered_date_begin',
        ];
    }

    /**
     * Define validation rule for account_id
     *
     * @param $authType
     * @return string|array
     */
    public static function getAccountIdRule($authType)
    {
        if ($authType === AUTH_TYPE_ACCOUNT_PASSWORD) {
            return [
                'bail',
                'required',
                'regex:/^((?![1lIoO0])[a-zA-Z0-9]){3}-((?![1lIoO0])[a-zA-Z0-9]){5}$/'
            ];
        }
        return 'bail|required';
    }
}
