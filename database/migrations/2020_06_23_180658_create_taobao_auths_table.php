<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaobaoAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taobao_auths', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->timestamp('expires_time')->index()->nullable()->comment('过期时间');

            $table->string('access_token');
            $table->string('token_type');
            $table->unsignedInteger('expires_in')->comment('Access token过期时间 10（表示10秒后过期）');
            $table->string('refresh_token')->comment('Refresh token，可用来刷新access_token');
            $table->unsignedInteger('re_expires_in')->comment('Refresh token过期时间');
            $table->unsignedInteger('r1_expires_in')->comment('r1级别API或字段的访问过期时间');
            $table->unsignedInteger('r2_expires_in')->comment('r1级别API或字段的访问过期时间');
            $table->unsignedInteger('w1_expires_in')->comment('r1级别API或字段的访问过期时间');
            $table->unsignedInteger('w2_expires_in')->comment('r1级别API或字段的访问过期时间');
            $table->string('taobao_user_nick')->comment('淘宝账号名(前台类应用获取的为混淆的账号名)');
            $table->string('taobao_user_id',60)->index()->comment('淘宝帐号对应id');
            $table->string('sub_taobao_user_id')->nullable()->comment('淘宝子账号对应id');
            $table->string('sub_taobao_user_nick')->nullable()->comment('淘宝子账号');

            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
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
        Schema::dropIfExists('taobao_auths');
    }
}
