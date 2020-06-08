<?php


namespace App\Http\Requests\Api;

use App\Enums\CorporationServiceStatus;
use Illuminate\Validation\Rule;

class ServiceContractStatusRequest extends BaseRequest
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
            'status' => [
                'bail',
                'required',
                Rule::in([
                    CorporationServiceStatus::INACTIVE,
                    CorporationServiceStatus::ACTIVE,
                    CorporationServiceStatus::RESTRICTED
                ])
            ]
        ];
    }
}
