<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbProvinces extends Migration{

    public function up(){
        Schema::create('tb_provinces', function(Blueprint $table){
            $table->smallInteger('id');
            $table->string('nama', 40);
            
            $table->index('id');
        });
    }

    public function down(){
        Schema::drop('tb_provinces');
    }
}
