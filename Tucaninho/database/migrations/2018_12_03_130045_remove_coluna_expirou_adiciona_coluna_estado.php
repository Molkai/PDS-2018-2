<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColunaExpirouAdicionaColunaEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('pedidos', 'estado')){
            Schema::table('pedidos', function($table){
                $table->smallInteger('estado')->default(0);
            });
        }

        if(Schema::hasColumn('pedidos', 'expirou')){
            Schema::table('pedidos', function($table){
                $table->dropColumn('expirou');
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
        if(Schema::hasColumn('pedidos', 'estado')){
            Schema::table('pedidos', function($table){
                $table->dropColumn('estado');
            });
        }
    }
}
