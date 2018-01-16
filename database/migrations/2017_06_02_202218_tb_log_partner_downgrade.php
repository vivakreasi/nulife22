<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbLogPartnerDowngrade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tb_log_partner_downgrade')) {
            Schema::create('tb_log_partner_downgrade', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('user_id');
                $table->string('userid', 20);
                $table->tinyInteger('from_id')->comment('1=stockist, 2=master stockist');
                $table->tinyInteger('to_id')->comment('1=stockist, 0=member');
                $table->string('reason', 100);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                
                $table->index('user_id');
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
        Schema::dropIfExists('tb_log_partner_downgrade');
    }
}
