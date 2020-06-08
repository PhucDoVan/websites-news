<?php

namespace App\Http\Helpers;

use Illuminate\Validation\Rule;

class ValidateAccountHelper
{
    /**
     * Define validation rules for store account
     *
     * @return array
     */
    public static function getStoreRules()
    {
        return [
            'corporation_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('corporations')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'username'       => [
                'bail',
                'required',
                'max:50',
                'regex:/^((?![1lIoO0])[a-zA-Z0-9]){3}-((?![1lIoO0])[a-zA-Z0-9]){5}$/',
                'unique:accounts'
            ],
            'password'       => 'bail|required|max:50',
            'name_last'      => 'bail|required|max:50',
            'name_first'     => 'bail|required|max:50',
            'kana_last'      => 'bail|required|max:50',
            'kana_first'     => 'bail|required|max:50',
            'restrict_ips'   => 'bail|nullable|array',
            'restrict_ips.*' => 'bail|nullable|distinct|ipv4',
        ];
    }

    /**
     * Define validation rules for edit account
     *
     * @return array
     */
    public static function getEditRules()
    {
        return [
            'account_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('accounts')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

    /**
     * Define validation rules for store account
     *
     * @param $accountId
     * @return array
     */
    public static function getUpdateRules($accountId)
    {
        return [
            'corporation_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('corporations')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'username'       => [
                'bail',
                'required',
                'max:50',
                'regex:/^((?![1lIoO0])[a-zA-Z0-9]){3}-((?![1lIoO0])[a-zA-Z0-9]){5}$/',
                Rule::unique('accounts')->ignore($accountId, 'account_id'),
            ],
            'password'       => 'bail|nullable|max:50',
            'name_last'      => 'bail|required|max:50',
            'name_first'     => 'bail|required|max:50',
            'kana_last'      => 'bail|required|max:50',
            'kana_first'     => 'bail|required|max:50',
            'restrict_ips'   => 'bail|nullable|array',
            'restrict_ips.*' => 'bail|nullable|distinct|ipv4',
        ];
    }

    /**
     * Define validation rules for delete account
     *
     * @return array
     */
    public static function getDeleteRules()
    {
        return [
            'account_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('accounts')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ]
        ];
    }

    /**
     * Define validation rules for upload file histories
     *
     * @return array
     */
    public static function getUploadFileHistoriesRules()
    {
        return [
            'file_history' => 'bail|required|mimes:csv,txt'
        ];
    }

    /**
     * Define validation rules for content of file histories
     *
     * @return array
     */
    public static function getContentFileHistoriesRules()
    {
        return [
            'file_content.*' => 'bail|required|numeric|digits_between:1,19'
        ];
    }

    /**
     * Define validation rules for import histories rules
     *
     * @return array
     */
    public static function getImportHistoriesRules()
    {
        return [
            'service_id'    => [
                'bail',
                'required',
                'integer',
                Rule::exists('services', 'service_id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'content_ids.*' => 'bail|required|numeric|digits_between:1,19'
        ];
    }

}
