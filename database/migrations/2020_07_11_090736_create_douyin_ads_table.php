<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_ads', function (Blueprint $table) {
            $table->id();
            $table->string('task_id', 60)->unique();
            $table->tinyInteger('state')->index()->comment('任务状态');
            $table->string('state_desc')->nullable();
            $table->string('reject_reason')->nullable();
            $table->string('aweme_id', 60)->index()->nullable()->comment('视频id');
            $table->string('aweme_author_id', 60)->index()->nullable()->comment('视频作者id');
            $table->string('pay_user_id', 60)->index()->nullable()->comment('投放账号id');
            $table->unsignedInteger('budget_int')->default(0)->comment('预算*1000');
            $table->unsignedInteger('aim_id')->default(0)->comment('aim_id');
            $table->boolean('aweme_check')->default(false)->comment('视频检测');
            $table->timestamp('create_time')->index()->nullable()->comment('发布时间');
            $table->integer('object_type')->nullable()->comment('未知');
            $table->boolean('allow_multi_deliverying')->default(false)->comment('允许多次传送');
            $table->boolean('is_live_order')->index()->default(false)->comment('直播订单');
            $table->unsignedInteger('digg_count')->default(0)->comment('点赞数');
            $table->unsignedInteger('play')->default(0)->comment('播放');
            $table->unsignedInteger('comment')->default(0)->comment('评论');
            $table->unsignedInteger('like')->default(0)->comment('喜欢');
            $table->unsignedInteger('fans')->default(0)->comment('粉丝');
            $table->unsignedInteger('show_visit_count')->default(0)->comment('访问量');
            $table->unsignedInteger('live_follow')->default(0)->comment('直播关注');
            $table->unsignedInteger('live_comment')->default(0)->comment('直播评论');


            $table->timestamp('cost_update_time')->nullable()->index()->comment('消耗更新时间');
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
        Schema::dropIfExists('douplus_tasks');
    }
}
