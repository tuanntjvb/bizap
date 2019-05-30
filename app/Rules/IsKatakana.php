<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsKatakana implements Rule
{
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
        return preg_replace('/[\x{30A0}-\x{30FF}\x{FF01}-\x{FF5E}\x{3041}-\x{3096}]/u', '', $value) == '';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeはカタカナで入力してください。';
    }
}
