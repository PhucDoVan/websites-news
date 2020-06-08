<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class LoginId implements Rule
{
    /**
     * 3 chars must in [a-zA-Z0-9] and not in [1lIoO0]
     * char "-"
     * 5 chars must in [a-zA-Z0-9] and not in [1lIoO0]
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = '/^((?![1lIoO0])[a-zA-Z0-9]){3}-((?![1lIoO0])[a-zA-Z0-9]){5}$/';
        return (boolean) preg_match($regex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.regex');
    }
}
