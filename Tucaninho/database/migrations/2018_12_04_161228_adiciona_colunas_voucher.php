<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaColunasVoucher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('pedidos', 'fileName')){
            Schema::table('pedidos', function($table){
                $table->text('fileName')->nullable()->default(null);
            });
        }

        if(!Schema::hasColumn('pedidos', 'filePath')){
            Schema::table('pedidos', function($table){
                $table->text('filePath')->nullable()->default(null);
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
        if(Schema::hasColumn('pedidos', 'fileName')){
            Schema::table('pedidos', function($table){
                $table->dropColumn('fileName');
            });
        }

        if(Schema::hasColumn('pedidos', 'filePath')){
            Schema::table('pedidos', function($table){
                $table->dropColumn('filePath');
            });
        }
    }
}
