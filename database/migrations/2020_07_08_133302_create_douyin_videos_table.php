<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_videos', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('aweme_id', 60)->unique()->comment('视频id');
            $table->string('author_user_id', 60)->index()->comment('作者id');
            $table->string('product_id', 60)->index()->nullable()->comment('商品id');
            $table->unsignedTinyInteger('product_type')->index()->nullable()->comment('商品类型 1小店 2淘宝');
            $table->tinyInteger('aweme_type')->index()->comment('视频类型');
            $table->unsignedBigInteger('create_time')->index()->comment('发布时间');
            $table->boolean('is_live_replay')->default(false)->comment('正在直播');
            $table->string('share_url')->nullable()->comment('分享链接');
            $table->text('desc')->nullable()->comment('视频标题');
            $table->integer('rate')->default(0)->comment('评分12正常 10不适宜公开');
            $table->integer('status_value')->default(0)->comment('140自己可见,143好友可见,144不适宜,102公开');
            $table->boolean('self_see')->default(false)->comment('自己可见');
            $table->boolean('with_goods')->default(false)->comment('带商品');
            $table->boolean('with_fusion_goods')->default(false)->comment('带商品');
            $table->boolean('with_goods_warn')->default(false)->comment('掉车提醒');
            $table->boolean('is_delete')->default(false)->comment('是否删除');
            $table->boolean('is_private')->default(false)->comment('是否隐藏');
            $table->boolean('is_prohibited')->default(false)->comment('是否被禁止');
            $table->integer('comment_count')->default(0);
            $table->integer('digg_count')->default(0);
            $table->integer('forward_count')->default(0);
            $table->integer('play_count')->default(0);
            $table->integer('share_count')->default(0);
            $table->text('play_addr')->nullable()->comment('播放地址');
            $table->text('origin_cover')->nullable()->comment('封面图');
            $table->timestamp('info_update_time')->nullable()->index()->comment('视频信息更新时间');
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('运营人id');
            $table->unsignedInteger('department_id')->nullable()->index()->comment('部门id');
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
        Schema::dropIfExists('douyin_videos');
    }
}
