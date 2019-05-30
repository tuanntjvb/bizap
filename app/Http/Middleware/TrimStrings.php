<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStrings extends BaseTrimmer
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];

    /**
     * Transform the given value.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }
        return is_string($value) ? $this->trimSpace($value) : $value;
    }

    /**
     * @param $value
     *
     * @return false|string
     */
    private function trimSpace($value)
    {
        $value = mb_ereg_replace("^[\n\r\s\t　]+", '', $value);
        $value = mb_ereg_replace("[\n\r\s\t　]+$", '', $value);
        return trim($value);
    }
}
