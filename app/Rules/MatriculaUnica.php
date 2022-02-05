<?php

namespace App\Rules;

use App\Models\Matricula;
use Illuminate\Contracts\Validation\Rule;

class MatriculaUnica implements Rule
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
        return !Matricula::where("aluno_id",$value)->whereNull("deleted_at")->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Aluno já tem uma matrícula ativa';
    }
}
