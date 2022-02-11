<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "matriculas";

    protected $fillable = ["aluno_id", "plano_id", "dt_inicio", "dt_fim"];

    protected $appends = ['desativado'];

    public function scopeAtivos($query)
    {
        return $query->whereNull("deleted_at");
    }

    public function scopeInativos($query)
    {
        return $query->whereNotNull("deleted_at");
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, "aluno_id", "id");
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, "plano_id", "id");
    }

    public function getDesativadoAttribute($value)
    {
        $hoje = new \DateTime();
        $expiracao = new \DateTime($this->dt_fim);

        return $hoje->diff($expiracao)->invert || !empty($this->deleted_at);
    }

    public static function matriculasPaginadas($search)
    {
        return Matricula::withTrashed()
            ->with("aluno", function ($query) {
                $query->withTrashed();
            })
            ->with("plano", function ($query) {
                $query->withTrashed();
            })
            ->whereHas('aluno', function ($query) use ($search) {
                $query->whereRaw("nome LIKE ? ", ["%$search%"])->withTrashed();
            })
            ->orWhereHas('plano', function ($query) use ($search) {
                $query->whereRaw("nome LIKE ? ", ["%$search%"])->withTrashed();
            })
            ->orderBy("matriculas.created_at", "DESC")
            ->paginate(10);
    }

    public static function detalhes($idMatricula)
    {
        return Matricula::withTrashed()
            ->with("aluno", function ($query) {
                $query->withTrashed();
            })
            ->with("plano", function ($query) {
                $query->withTrashed();
            })
            ->where(["id" => $idMatricula])->first();
    }

    public static function matriculaPorID($idMatricula)
    {
        return Matricula::withTrashed()->where(["id" => $idMatricula])->first();
    }

    public static function createComDuracao($dados, $duracaoPlano)
    {
        $dataInicio = (new \DateTime($dados["dt_inicio"]))->format("Y-m-d");
        $dataFim = (new \DateTime($dados["dt_inicio"]))
            ->add(\DateInterval::createFromDateString("+{$duracaoPlano}months"))
            ->format("Y-m-d");

        $dados["dt_inicio"] = $dataInicio;
        $dados["dt_fim"] = $dataFim;

        return self::create($dados);
    }
}
