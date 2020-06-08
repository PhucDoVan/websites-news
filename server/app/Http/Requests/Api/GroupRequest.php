<?php


namespace App\Http\Requests\Api;

use App\Http\Rules\MaxSeparate;

class GroupRequest extends BaseRequest
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
            'page'            => 'bail|nullable|numeric|min:1',
            'limit'           => 'bail|nullable|numeric|min:1',
            'parent_group_id' => 'bail|nullable|numeric',
            'group_ids'       => ['bail', 'nullable', 'string', new MaxSeparate(50)],
        ];
    }
}
