<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlancWd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c_wd')) {
            Schema::create('tb_plan_c_wd', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamp('tgl_wd')->useCurrent();
                $table->integer('userid');
                $table->integer('plan_c_id');
                $table->integer('bonus_c_id');
                $table->integer('bonus_c_type');
                $table->bigInteger('jml_bonus');
                $table->integer('jml_pot_admin');
                $table->integer('jml_pot_pph');
                $table->bigInteger('jml_wd');
                $table->integer('ref_order_id')->default(0);
                $table->tinyInteger('status')->default(0);
                $table->timestamp('tgl_status')->nullable();
                $table->timestamps();
                $table->string('reject_note', 250)->nullable();
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
        Schema::dropIfExists('tb_plan_c_wd');
    }
}
