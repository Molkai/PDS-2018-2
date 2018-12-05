<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaCamposAvaliacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('cliente', 'nota')){
            Schema::table('cliente', function($table){
                $table->decimal('nota', 2, 1)->default(0);
            });
        }

        if(!Schema::hasColumn('cliente', 'qntAvaliacoes')){
            Schema::table('cliente', function($table){
                $table->integer('qntAvaliacoes')->default(0);
            });
        }

        if(!Schema::hasColumn('agente', 'nota')){
            Schema::table('agente', function($table){
                $table->decimal('nota', 2, 1)->default(0);
            });
        }

        if(!Schema::hasColumn('agente', 'qntAvaliacoes')){
            Schema::table('agente', function($table){
                $table->integer('qntAvaliacoes')->default(0);
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
        if(Schema::hasColumn('cliente', 'nota')){
            Schema::table('cliente', function($table){
                $table->dropColumn('nota');
            });
        }

        if(!Schema::hasColumn('cliente', 'qntAvaliacoes')){
            Schema::table('cliente', function($table){
                $table->dropColumn('qntAvaliacoes');
            });
        }

        if(!Schema::hasColumn('agente', 'nota')){
            Schema::table('agente', function($table){
                $table->dropColumn('nota');
            });
        }

        if(!Schema::hasColumn('agente', 'qntAvaliacoes')){
            Schema::table('agente', function($table){
                $table->dropColumn('qntAvaliacoes');
            });
        }
    }
}
