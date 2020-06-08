<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostalCodeRule implements Rule
{

    /**
     * Pattern in range:
     * 1. ###-####
     * 2. #######
     *
     * @var string
     */
    private $pattern = '/^[0-9]{3}(-?)([0-9]{4})?$/';

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match($this->pattern, $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return trans('validation.postal_code');
    }
}
