<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBonusReward extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_bonus_reward')) {
            Schema::create('tb_bonus_reward', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('userid', 20);
                $table->integer('reward_id');
                $table->integer('reward_value');
                $table->string('reward_name', 100)->nullable();
                $table->integer('foot_left');
                $table->integer('foot_right');
                $table->integer('claim_as');
                $table->integer('status');
                $table->string('note', 100)->nullable();
                $table->timestamp('confirm_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                /*  define unique key */
                $table->unique(['user_id', 'reward_id']);
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
        Schema::dropIfExists('tb_bonus_reward');
    }
}
