<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbRewardSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_reward_setting')) {
            Schema::create('tb_reward_setting', function (Blueprint $table) {
                $table->increments('id');
                $table->string('plan', 1);
                $table->integer('target')->default(0);
                $table->integer('reward_by_value')->default(0);
                $table->string('reward_by_name', 100)->nullable();
                $table->integer('reward_by')->default(1);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();

                $table->unique(['plan', 'target']);
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
        Schema::dropIfExists('tb_reward_setting');
    }
}
