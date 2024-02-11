<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [ 'nome', 'cpf', 'whatsApp', 'email' ];

    public function getInfoAttribute()
    {
        return $this->nome . ' - ' . $this->whatsApp;
    }
}
