<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->connection('mysql')->getSchemaBuilder();

        if (!$schema->hasTable('users')) :
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('lastname');
                $table->string('email')->unique();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->enum('active', ['Y', 'N'])->default('Y');
                $table->integer('roles_id')->unsigned()->default(1);
                $table->timestamps();

                $table->foreign('roles_id')->references('id')->on('roles');
            });
        else :
            Schema::table('users', function (Blueprint $table) {
                $table->integer('roles_id')->unsigned()->default(1);
                
                $table->foreign('roles_id')->references('id')->on('roles');
            });
        endif;

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
