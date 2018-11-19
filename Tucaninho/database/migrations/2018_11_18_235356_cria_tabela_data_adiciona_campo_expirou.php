<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaDataAdicionaCampoExpirou extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('datas')){
            Schema::create('datas', function($table){
                $table->string('email_cliente', 100);
                $table->timestamp('pedido_id');
                $table->date('data');
                $table->string('cidade', 100);
                $table->string('pais', 100);
                $table->string('aeroporto', 100);

                $table->foreign(['email_cliente', 'pedido_id'])
                    ->references(['email_cliente', 'pedido_id'])->on('pedidos')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->primary(['email_cliente', 'pedido_id', 'data', 'cidade']);
            });
        }

        if(!Schema::hasColumn('pedidos', 'expirou')){
            Schema::table('pedidos', function($table){
                $table->boolean('expirou')->default(TRUE);
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
        if(Schema::hasColumn('pedidos', 'expirou')){
            Schema::table('pedidos', function($table){
                $table->dropColumn('expirou');
            });
        }

        Schema::dropIfExists('datas');
    }
}
