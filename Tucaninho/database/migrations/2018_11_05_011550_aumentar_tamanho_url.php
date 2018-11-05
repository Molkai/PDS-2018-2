<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AumentarTamanhoUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if(Schema::hasColumn('url_pedido', 'url')){
            Schema::table('url_pedido', function ($table) {
                $table->string('url', 2000)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        if(Schema::hasColumn('url_pedido', 'url')){
            Schema::table('url_pedido', function ($table) {
                $table->string('url', 200)->change();
            });
        }
    }
}
