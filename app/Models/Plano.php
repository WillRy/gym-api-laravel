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
        return $query->whereNull("deleted_at");
    }

    public function scopeInativos($query)
    {
        return $query->whereNotNull("deleted_at");
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, "plano_id", "id");
    }

    public static function planosPaginado($search)
    {
        return Plano::withTrashed()
            ->when(!empty($search), function ($q) use ($search) {
                $q->whereRaw("nome LIKE ?", ["%$search%"]);
            })
            ->paginate(10);
    }

    public static function planoPorID($idPlano)
    {
        return Plano::withTrashed()->where(["id" => $idPlano])->first();
    }
}
