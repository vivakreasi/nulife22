<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbKota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('tb_kota', function(Blueprint $table){
            $table->smallInteger('id');
            $table->smallInteger('id_province');
            $table->string('nama_kota', 40);
            
            $table->index('id');
            $table->index('id_province');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_kota');
    }
}
