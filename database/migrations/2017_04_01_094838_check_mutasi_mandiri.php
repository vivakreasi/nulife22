<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CheckMutasiMandiri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c_mandiri')) {
            Schema::create('tb_plan_c_mandiri', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('no_urut');
                $table->timestamp('tgl_check')->nullable();
                $table->timestamp('tgl_transaksi')->nullable();
                $table->string('uraian_transaksi', 250);
                $table->double('credit', 16, 2);
                $table->bigInteger('angka_pokok')->default(0);
                $table->integer('angka_unik')->default(0);
                $table->double('angka_desimal', 16, 2)->default(0);
                $table->tinyInteger('processed')->default(0);
                $table->timestamps();
                $table->integer('id_mutasi')->default(0);
            });
        }

        if (!Schema::hasTable('tb_mutasi_mandiri')) {
            Schema::create('tb_mutasi_mandiri', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('no_urut');
                $table->timestamp('tgl_check')->nullable();
                $table->timestamp('tgl_transaksi')->nullable();
                $table->string('uraian_transaksi', 250);
                $table->double('debit', 16, 2);
                $table->double('credit', 16, 2);
                $table->timestamps();
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
        Schema::dropIfExists('tb_plan_c_mandiri');
        Schema::dropIfExists('tb_mutasi_mandiri');
    }
}
