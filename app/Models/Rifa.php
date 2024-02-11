<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'observacao', 'valor', 'maximo_de_vendas', 'imagem', 'status', 'data_sorteio'];

    public function premios(){
        return $this->hasMany(PremioRifa::class, 'rifa_id');
    }
}
