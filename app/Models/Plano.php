<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "planos";

    protected $fillable = ["nome", "descricao", "duracao", "valor"];

    public function scopeAtivos($query)
    {
        return $query->withoutTrashed();
    }

    public function scopeInativos($query)
    {
        return $query->onlyTrashed();
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, "plano_id", "id");
    }

    public static function planosPaginado($search, $filtroAtivo = "todos")
    {
        return Plano::query()
            ->when(!empty($search), function ($q) use ($search) {
                $q->whereRaw("nome LIKE ?", ["%$search%"]);
            })
            ->when(!empty($filtroAtivo), function ($q) use ($filtroAtivo) {
                if ($filtroAtivo === "todos") {
                    $q->withTrashed(); //incluir ativos e inativos
                } elseif ($filtroAtivo === "ativo") {
                    $q->ativos();
                } else {
                    $q->inativos();
                }
            })
            ->paginate(10);
    }

    public static function planoPorID($idPlano)
    {
        return Plano::withTrashed()->where(["id" => $idPlano])->first();
    }
}
