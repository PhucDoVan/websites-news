<?php

namespace App\Http\Requests\Api;

class CorporationInformationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'bail|nullable|string|max:100',
            'kana'           => 'bail|nullable|string|max:100',
            'postal'         => 'bail|nullable|string|max:7',
            'address_pref'   => 'bail|nullable|string|max:50',
            'address_city'   => 'bail|nullable|string|max:50',
            'address_town'   => 'bail|nullable|string|max:50',
            'address_etc'    => 'bail|nullable|string|max:50',
        ];
    }
}
