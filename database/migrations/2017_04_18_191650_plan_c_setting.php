<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanCSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c_setting')) {
            Schema::create('tb_plan_c_setting', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('max_c_account');
                $table->bigInteger('bonus_fly');
                $table->bigInteger('cost_pkg');
                $table->bigInteger('pin_ruby');
                $table->bigInteger('pin_saphire');
                $table->bigInteger('pin_emerald');
                $table->bigInteger('pin_diamond');
                $table->bigInteger('pin_red_diamond');
                $table->bigInteger('pin_blue_diamond');
                $table->bigInteger('pin_white_diamond');
                $table->bigInteger('pin_black_diamond');
                $table->smallInteger('multiple_queue')->default(6);
                $table->smallInteger('current_queue');
                $table->timestamps();
            });

            //  init default value of settings
            DB::table('tb_plan_c_setting')->insert(['max_c_account'     => 15,
                                                    'bonus_fly'         => 1600000,
                                                    'cost_pkg'          => 500000,
                                                    'pin_ruby'          => 90000,
                                                    'pin_saphire'       => 80000,
                                                    'pin_emerald'       => 70000,
                                                    'pin_diamond'       => 60000,
                                                    'pin_red_diamond'   => 50000,
                                                    'pin_blue_diamond'  => 40000,
                                                    'pin_white_diamond' => 30000,
                                                    'pin_black_diamond' => 20000,
                                                    'multiple_queue'    => 6,
                                                    'current_queue'     => 0
                                                    ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_plan_c_setting');
    }
}
