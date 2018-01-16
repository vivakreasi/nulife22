<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c')) {
            Schema::create('tb_plan_c', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('pin_id');
                $table->string('plan_c_code',13);
                $table->timestamps();
                $table->timestamp('fly_at')->nullable();
                /*  define unique key */
                $table->unique('plan_c_code');
                $table->index('user_id');
                $table->index('pin_id');
            });
        }

        if (!Schema::hasTable('tb_plan_c_board')) {
            Schema::create('tb_plan_c_board', function (Blueprint $table) {
                $table->integer('id');
                $table->integer('plan_c_id');
                $table->integer('parent_id');
                $table->integer('no_urut');
                $table->timestamps();
                /*  define unique / index key */
                $table->primary(['id', 'plan_c_id']);
                $table->unique(['plan_c_id', 'parent_id']);
                $table->index('plan_c_id');
                $table->index('parent_id');
            });
        }

        if (!Schema::hasTable('tb_plan_c_bonus')) {
            Schema::create('tb_plan_c_bonus', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('board_c_id');
                $table->integer('plan_c_id');
                $table->integer('bonus_type');
                $table->integer('bonus_amount');
                $table->timestamps();
                /*  define unique / index key */
                $table->index('plan_c_id');
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
        Schema::dropIfExists('tb_plan_c');
        Schema::dropIfExists('tb_plan_c_board');
        Schema::dropIfExists('tb_plan_c_bonus');
    }
}
