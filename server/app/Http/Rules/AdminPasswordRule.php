<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class AdminPasswordRule implements Rule
{

    /**
     * Pattern:
     * 1. At least one char in [a-z]
     * 2. At least one char in [A-Z]
     * 3. At least one char in [0-9]
     *
     * @var string
     */
    private $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{10,50}$/';

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
        return trans('validation.admin_password');
    }
}
