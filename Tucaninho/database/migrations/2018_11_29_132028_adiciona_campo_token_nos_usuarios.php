<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaCampoTokenNosUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('cliente', 'token')){
            Schema::table('cliente', function($table){
                $table->string('token', 128)->nullable()->default(null);
            });
        }

        if(!Schema::hasColumn('agente', 'token')){
            Schema::table('agente', function($table){
                $table->string('token', 128)->nullable()->default(null);
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
        if(Schema::hasColumn('cliente', 'token')){
            Schema::table('cliente', function($table){
                $table->dropColumn('token');
            });
        }

        if(Schema::hasColumn('agente', 'token')){
            Schema::table('agente', function($table){
                $table->dropColumn('token');
            });
        }
    }
}
