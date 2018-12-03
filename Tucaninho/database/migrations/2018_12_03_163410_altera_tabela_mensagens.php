<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteraTabelaMensagens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('mensagens', 'isFile')){
            Schema::table('mensagens', function($table){
                $table->boolean('isFile')->default(false);
            });
        }

        if(!Schema::hasColumn('mensagens', 'fileName')){
            Schema::table('mensagens', function($table){
                $table->text('fileName')->nullable()->default(null);
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
        if(Schema::hasColumn('mensagens', 'isFile')){
            Schema::table('mensagens', function($table){
                $table->dropColumn('isFile');
            });
        }

        if(Schema::hasColumn('mensagens', 'fileName')){
            Schema::table('mensagens', function($table){
                $table->dropColumn('fileName');
            });
        }
    }
}
