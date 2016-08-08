<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('admin_role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('admin_users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('admin_roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fid')->unsigned()->default(0)->comment('菜单父ID');
            $table->string('icon')->nullable()->comment('图标class');
            $table->string('name')->unique()->comment('权限名,采用route');
            $table->string('display_name')->nullable()->comment('权限显示名称');
            $table->string('description')->nullable()->comment('描述');
            $table->tinyInteger('is_menu')->default(0)->comment('是否作为菜单显示,[1|0]');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('admin_permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('admin_permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('admin_roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('admin_permission_role');
        Schema::drop('admin_permissions');
        Schema::drop('admin_role_user');
        Schema::drop('admin_roles');
    }
}
