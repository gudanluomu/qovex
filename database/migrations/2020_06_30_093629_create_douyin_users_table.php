<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_users', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('bind_phone', 16)->nullable()->index()->comment('抖音绑定手机号');
            $table->string('uid', 60)->unique()->comment('抖音唯一id');
            $table->string('short_id', 60)->nullable()->index()->comment('short_id');
            $table->string('unique_id', 60)->nullable()->index()->comment('账号');
            $table->string('avatar_url')->nullable()->comment('头像');
            $table->string('nickname', 60)->nullable()->index()->comment('昵称');
            $table->string('sec_uid')->nullable()->comment('sec_uid');
            $table->integer('aweme_count')->default(0)->comment('作品数');
            $table->integer('following_count')->default(0)->comment('关注');
            $table->integer('follower_count')->default(0)->comment('粉丝');
            $table->boolean('with_fusion_shop_entry')->default(false)->index()->comment('橱窗');
            $table->boolean('with_commerce_entry')->default(false)->index()->comment('橱窗');
            $table->boolean('bind_taobao_pub')->default(false)->index()->comment('绑定淘宝');
            $table->boolean('with_shop_entry')->default(false)->index()->comment('是否带商店入口');
            $table->string('pid', 80)->nullable()->comment('淘宝mm码');
            $table->string('member_id', 60)->nullable()->index();
            $table->string('site_id', 60)->nullable()->index();
            $table->string('adzone_id', 60)->nullable()->index();
            $table->text('cookie')->nullable()->comment('cookie');
            $table->boolean('cookie_status')->default(false)->index()->comment('cookie状态');
            $table->timestamp('cookie_expire_time')->nullable()->index()->comment('cookie过期时间');
            $table->timestamp('info_update_time')->nullable()->index()->comment('账号信息更新时间');
            $table->timestamp('pid_update_time')->nullable()->index()->comment('推广位更新时间');
            $table->timestamp('del_comment_at')->nullable()->index()->comment('开启控评时间,未开启为null');
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('运营人id');
            $table->unsignedInteger('department_id')->nullable()->index()->comment('部门id');
            $table->timestamps();
            $table->unique(['group_id', 'uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('douyin_users');
    }
}
