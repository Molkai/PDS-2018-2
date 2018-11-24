<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaMensagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('mensagens')){
            Schema::create('mensagens', function($table){
                $table->string('email_cliente', 100);
                $table->string('email_agente', 100);
                $table->timestamp('pedido_id');
                $table->timestamp('mensagem_id');
                $table->text('mensagem');
                $table->boolean('isCliente');

                $table->foreign(['email_cliente', 'pedido_id', 'email_agente'])
                    ->references(['email_cliente', 'pedido_id', 'email_agente'])->on('oferta')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->primary(['email_cliente', 'pedido_id', 'email_agente', 'mensagem_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensagens');
    }
}
