<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premiacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id', 'premio_id', 'observacao'
    ];
}
