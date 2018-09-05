<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('user_id', true);
            $table->string('username')->unique('username');
            $table->string('password')->nullable();
            $table->string('realname', 64);
            $table->string('email', 64);
            $table->char('descr', 30);
            $table->tinyInteger('level')->default(0);
            $table->boolean('can_modify_passwd')->default(1);
            $table->timestamp('created_at')->default('1970-01-02 00:00:01');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('remember_token', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
