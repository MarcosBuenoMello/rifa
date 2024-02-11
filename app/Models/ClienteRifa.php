<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRifa extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'cliente_id', 'rifa_id', 'qr_code_base64', 'qr_code', 'transacao_id', 'status_pagamento', 'cupom'
    ];

    public function rifa(){
        return $this->belongsTo(Rifa::class, 'rifa_id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
