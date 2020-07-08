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
            $table->string('expire_time', 60)->index()->nullable()->comment('过期时间');
            $table->string('access_token')->nullable();
            $table->string('token_type')->nullable();
            $table->unsignedInteger('expires_in')->nullable()->comment('Access token过期时间 10（表示10秒后过期）');
            $table->string('refresh_token')->nullable()->comment('Refresh token，可用来刷新access_token');
            $table->string('refresh_token_valid_time')->nullable();
            $table->unsignedInteger('re_expires_in')->nullable()->comment('Refresh token过期时间');
            $table->unsignedInteger('r1_expires_in')->nullable()->comment('r1级别API或字段的访问过期时间');
            $table->string('r1_valid')->nullable();
            $table->unsignedInteger('r2_expires_in')->nullable()->comment('r1级别API或字段的访问过期时间');
            $table->string('r2_valid')->nullable();
            $table->unsignedInteger('w1_expires_in')->nullable()->comment('r1级别API或字段的访问过期时间');
            $table->string('w1_valid')->nullable();
            $table->unsignedInteger('w2_expires_in')->nullable()->comment('r1级别API或字段的访问过期时间');
            $table->string('w2_valid')->nullable();
            $table->string('taobao_open_uid')->nullable();
            $table->string('taobao_user_nick')->nullable()->comment('淘宝账号名(前台类应用获取的为混淆的账号名)');
            $table->string('taobao_user_id', 60)->nullable()->index()->comment('淘宝帐号对应id');
            $table->string('sub_taobao_user_id')->nullable()->comment('淘宝子账号对应id');
            $table->string('sub_taobao_user_nick')->nullable()->comment('淘宝子账号');

            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id');
            $table->timestamps();
            $table->softDeletes();
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
