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

    public static function alunosPaginados($search)
    {
        return Aluno::withTrashed()
            ->with("matricula", function ($query) {
                $query->with("plano", function ($query) {
                    $query->withTrashed();
                });
            })
            ->when(!empty($search), function ($q) use ($search) {
                $q->whereRaw("nome LIKE ?", ["%$search%"]);
            })
            ->paginate(10);
    }

    public static function alunoDetalhes($idAluno)
    {
        return Aluno::withTrashed()
            ->with("matricula", function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where(["id" => $idAluno])
            ->first();
    }

    public static function alunoPorID($idAluno)
    {
        return Aluno::withTrashed()->where(["id" => $idAluno])->first();
    }
}
