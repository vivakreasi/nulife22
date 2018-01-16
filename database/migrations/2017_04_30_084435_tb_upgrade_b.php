<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbUpgradeB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_upgrade_b')) {
            Schema::create('tb_upgrade_b', function (Blueprint $table) {
                $table->increments('id');
                $table->string('upgrade_kode', 15)->unique();
                $table->integer('user_id')->unique();
                $table->string('userid', 20)->unique();
                $table->integer('foot_left');
                $table->integer('foot_right');
                $table->integer('upgrade_price');
                $table->string('unique_digit', 3);
                $table->integer('total_price');
                $table->integer('bank_id');
                $table->string('upload_file', 200)->nullable();
                $table->timestamp('upload_at')->nullable();
                $table->integer('status')->default(0);
                $table->string('note', 100)->nullable();
                $table->integer('approove_by');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                /*  define unique key */
                $table->index('status');
                $table->index('bank_id');
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
        Schema::dropIfExists('tb_upgrade_b');
    }
}
