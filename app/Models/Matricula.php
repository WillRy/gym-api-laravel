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
}
