<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaCamposDestinoNaTabelaDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('datas')){
            Schema::table('datas', function($table){
                $table->string('cidadeDestino', 100);
                $table->string('paisDestino', 100);
                $table->string('aeroportoDestino', 100);
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
        if(Schema::hasColumn('datas', 'cidadeDestino')){
              Schema::table('datas', function($table){
                $table->dropColumn('cidadeDestino');
              });
        }
        if(Schema::hasColumn('datas', 'paisDestino')){
              Schema::table('datas', function($table){
                $table->dropColumn('paisDestino');
              });
        }
        if(Schema::hasColumn('datas', 'aeroportoDestino')){
              Schema::table('datas', function($table){
                $table->dropColumn('aeroportoDestino');
              });
        }
    }
}
