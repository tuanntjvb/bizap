<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MustContain implements Rule
{
    private $parameters;
    private $emptyResult = false;

    /**
     * Create a new rule instance.
     */
    public function __construct($parameters, $emptyResult = true)
    {
        $this->parameters = $parameters;
        $this->emptyResult = $emptyResult;
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
        if (empty($value)) {
            return $this->emptyResult;
        }
        $result = false;
        if (is_array($this->parameters)) {
            foreach ($this->parameters as $parameter => $minCount) {
                if ($minCount <= 0) {
                    $result = true;
                    break;
                }
                if (str_contains($value, $parameter)) {
                    if ($minCount == 1) {
                        $result = true;
                        break;
                    } else {
                        $explodeKeys = explode($parameter, $value);
                        if ((count($explodeKeys) - 1) >= $minCount) {
                            $result = true;
                            break;
                        }

                    }
                }
            }
        } else {
            $result = str_contains($value, $this->parameters);
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must contain some special key';
    }
}
