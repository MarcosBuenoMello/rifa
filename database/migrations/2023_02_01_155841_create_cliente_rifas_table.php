<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteRifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_rifas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('rifa_id')->nullable()->constrained('rifas');
            $table->string('cupom', 10);
            $table->text('qr_code_base64');
            $table->text('qr_code');
            $table->string('transacao_id', 100)->default('');
            $table->string('status_pagamento', 15)->default('');

            // alter table cliente_rifas add column cupom varchar(10) default '';
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_rifas');
    }
}
