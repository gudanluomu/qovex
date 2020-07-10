<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouplusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doupluses', function (Blueprint $table) {
            $table->id();
            $table->string('aweme_id', 60)->nullable()->index()->comment('视频id');
            $table->string('author_user_id', 60)->nullable()->index()->comment('视频抖音号id');
            $table->string('pay_user_id', 60)->nullable()->index()->comment('付款抖音号id');
            $table->timestamp('time')->nullable()->index()->comment('定时投放');
            $table->boolean('is_run')->default(false)->index()->comment('是否已运行,针对定时,非定时true');
            $table->unsignedInteger('budget_num')->default(0)->comment('预估投放次数');
            $table->unsignedInteger('real_num')->default(0)->comment('真实投放次数');
            $table->unsignedInteger('budget_amount')->default(0)->comment('预估金额合计');
            $table->unsignedInteger('real_amount')->default(0)->comment('真实投放金额合计');
            $table->text('info')->nullable()->comment('投放详情');
            $table->longText('contents')->nullable()->comment('投放response');
            $table->unsignedInteger('creator_id')->nullable()->index()->comment('操作人');
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('视频当时运营人id');
            $table->unsignedInteger('department_id')->nullable()->index()->comment('视频当时部门id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doupluses');
    }
}
