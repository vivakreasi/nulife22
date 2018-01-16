<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbBonusCLeadership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_plan_c_bonus_ld')) {
            Schema::create('tb_plan_c_bonus_ld', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('userid', 60);
                $table->integer('from_c_id');
                $table->integer('from_user_id');
                $table->string('from_userid', 60);
                $table->integer('from_structure_id');
                $table->integer('from_structure_level');
                $table->integer('bonus_amount');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                /*  define unique key */
                $table->unique(['user_id', 'from_c_id']);
                $table->index('from_c_id');
                $table->index('userid');
                $table->index('from_user_id');
                $table->index('from_userid');
                $table->index('from_structure_id');
                $table->index('from_structure_level');
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
        Schema::dropIfExists('tb_plan_c_bonus_ld');
    }
}
