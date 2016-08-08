<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('用户名');
            $table->string('email')->unique()->comment('账号邮箱');
            $table->string('password')->comment('密码');
            $table->tinyInteger('is_super')->default(0)->comment('是否超级管理员');
            $table->rememberToken();
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
        Schema::drop('admin_users');
    }
}
