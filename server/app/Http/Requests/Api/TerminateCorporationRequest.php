<?php

namespace App\Http\Requests\Api;

class TerminateCorporationRequest extends BaseRequest
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
            'datetime' => 'bail|required|date_format:"Y-m-d H:i:s"'
        ];
    }
}
