<?php

namespace App\Rules;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class InArrayValues implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $roles = Role::all('id')->toArray();

        if(!is_array($value)) {
            $fail('incorrect role');
        } else {
            $roles_id = array_column($roles, 'id');

            foreach ($value as $val) {
                if(!in_array($val, $roles_id)) {
                    $fail('incorrect role');
                }
            }
        }
    }
}
