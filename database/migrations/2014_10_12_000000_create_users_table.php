<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_head')->default(false)->comment('是否团长');
            $table->unsignedTinyInteger('role_scope')->default(2)->comment('权限范围 1全部数据 2管辖范围');
            $table->unsignedInteger('department_id')->nullable()->index()->comment('部门id');
            $table->unsignedTinyInteger('department_type')->default(1)->index()->comment('身份 1员工 2上级');
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
        Schema::dropIfExists('users');
    }
}
