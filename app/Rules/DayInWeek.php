<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DayInWeek implements Rule
{
    const DAYS = [
        'SUN' => 0,
        'MUN' => 1,
        'TUE' => 2,
        'WEB' => 3,
        'THU' => 4,
        'FRI' => 5,
        'SAT' => 6,
        'SUN_END' => 7,
    ];

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, self::DAYS);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.not_in');
    }
}
