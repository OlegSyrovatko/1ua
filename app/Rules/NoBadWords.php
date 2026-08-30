<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoBadWords implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $badWords = [
            'хуй', 'пизд', 'конч', 'сперм', 'йобн', 'шлюх', 'fuck', 'гом', 'бля', 'манд', 'член', 'еба', 'єба', 'суч', 'сук', 'дроч', 'писк', 'піськ', 'урод', 'соса', 'ублюд', 'соси', 'сран', 'срак', 'срат', 'хуев', 'костр', 'блев', 'трах', 'підар', 'онан'
        ];
        foreach ($badWords as $word) {
            if (stripos($value, $word) !== false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('messages.bad_words');
    }
}
