<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaColunaEstadoOferta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('oferta', 'estado')){
            Schema::table('oferta', function($table){
                $table->smallInteger('estado')->default(0);
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
        if(Schema::hasColumn('oferta', 'estado')){
            Schema::table('oferta', function($table){
                $table->dropColumn('estado');
            });
        }
    }
}
