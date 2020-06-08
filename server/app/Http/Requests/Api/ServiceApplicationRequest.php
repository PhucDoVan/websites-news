<?php


namespace App\Http\Requests\Api;


class ServiceApplicationRequest extends BaseRequest
{
    /**
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
            'corporation.name'         => 'bail|required|string|max:100',
            'corporation.kana'         => 'bail|required|string|max:100',
            'corporation.postal'       => 'bail|required|string|max:7',
            'corporation.address_pref' => 'bail|required|string|max:50',
            'corporation.address_city' => 'bail|required|string|max:50',
            'corporation.address_town' => 'bail|required|string|max:50',
            'corporation.address_etc'  => 'bail|nullable|string|max:50',
            'corporation.tel'          => 'bail|required|string|max:50',
            'corporation.email'        => 'bail|required|string|email|max:250',
            'account.last_name'        => 'bail|required|string|max:50',
            'account.first_name'       => 'bail|required|string|max:50',
            'account.last_kana'        => 'bail|required|string|max:50',
            'account.first_kana'       => 'bail|required|string|max:50',
            'contract.reason'          => 'bail|nullable|string|max:255',
        ];
    }
}
