<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StrukturJaringan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_structure')) {
            Schema::create('tb_structure', function (Blueprint $table) {
                $table->increments('id');
                $table->text('kode')->nullable();
                $table->integer('user_id')->unique();
                $table->string('userid', 60)->unique();
                $table->integer('upline_id');
                $table->string('upline', 60);
                $table->smallInteger('posisi');
                $table->smallInteger('level');
                $table->smallInteger('foot');
                $table->timestamps();

                $table->index('upline_id');
                $table->index('upline');
                $table->index('level');
                $table->index('foot');
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
        Schema::dropIfExists('tb_structure');
    }
}
