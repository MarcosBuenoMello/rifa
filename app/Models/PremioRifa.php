<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremioRifa extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'rifa_id', 'imagem'];

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'rifa_id');
    }

}
