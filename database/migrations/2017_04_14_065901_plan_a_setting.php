<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PlanASetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_a_setting')) {
            Schema::create('tb_plan_a_setting', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('max_account');
                $table->integer('min_upgrade_b');
                $table->integer('cost_reach_upgrade_b');
                $table->integer('cost_unreach_upgrade_b');
                $table->integer('bonus_sponsor');
                $table->integer('bonus_pairing');
                $table->integer('max_pairing_day');
                $table->integer('flush_out_pairing');
                $table->integer('bonus_split_nupoint');
                $table->timestamps();
            });

            DB::table('tb_plan_a_setting')->insert(['max_account'           => 15,
                                                'min_upgrade_b'         => 50,
                                                'cost_reach_upgrade_b'  => 500000,
                                                'cost_unreach_upgrade_b' => 600000,
                                                'bonus_sponsor'         => 100000,
                                                'bonus_pairing'         => 25000,
                                                'max_pairing_day'       => 20,
                                                'flush_out_pairing'     => 0,
                                                'bonus_split_nupoint'   => 20]);
        }

        if (!Schema::hasTable('tb_plan_b_setting')) {
            Schema::create('tb_plan_b_setting', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('bonus_up_member_b');
                $table->tinyInteger('require_planb')->default(1);
                $table->integer('bonus_sponsor');
                $table->integer('bonus_pairing');
                $table->integer('max_pairing_day');
                $table->integer('flush_out_pairing');
                $table->integer('bonus_split_nupoint');
                $table->timestamps();
            });

            DB::table('tb_plan_b_setting')->insert(['bonus_up_member_b'     => 50000,
                                                'require_planb'         => 1,
                                                'bonus_sponsor'         => 100000,
                                                'bonus_pairing'         => 25000,
                                                'max_pairing_day'       => 40,
                                                'flush_out_pairing'     => 0,
                                                'bonus_split_nupoint'   => 20]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_plan_a_setting');
        Schema::dropIfExists('tb_plan_b_setting');
    }
}
