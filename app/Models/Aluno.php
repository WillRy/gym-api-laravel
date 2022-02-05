<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "alunos";

    protected $fillable = ["nome", "email", "dt_nascimento", "sexo"];

    public function scopeAtivos($query)
    {
        return $query->whereNull("deleted_at");
    }

    public function scopeInativos($query)
    {
        return $query->whereNotNull("deleted_at");
    }

    public function matricula()
    {
        return $this->hasOne(Matricula::class, "aluno_id", "id");
    }
}
