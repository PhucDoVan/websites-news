<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errorResponse = [];

        $errors = $validator->errors()->toArray();
        foreach ($errors as $key => $messages) {
            foreach ($messages as $message) {
                $errorResponse[] = [
                    'target'  => $key,
                    'message' => $message
                ];
            }
        }

        $response = response()->json(
            [
                'error'       => $errorResponse
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        throw new ValidationException($validator, $response);
    }
}
