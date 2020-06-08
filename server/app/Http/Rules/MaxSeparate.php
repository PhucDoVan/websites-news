<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxSeparate implements Rule
{
    private $maxItem;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxItem)
    {
        $this->maxItem = $maxItem;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $values = explode(',', $value);
        return count($values) <= $this->maxItem;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.max.array', [
            'max' => $this->maxItem
        ]);
    }
}
