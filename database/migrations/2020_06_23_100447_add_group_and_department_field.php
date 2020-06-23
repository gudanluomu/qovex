<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupAndDepartmentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id')->after('id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id')->after('id');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->nullable()->index()->comment('团队id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['group_id']);
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['group_id']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['group_id']);
        });
    }
}
