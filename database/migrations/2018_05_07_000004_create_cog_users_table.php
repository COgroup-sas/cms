<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCogUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->connection('mysql')->getSchemaBuilder();

        Schema::disableForeignKeyConstraints();

        if (!$schema->hasTable('users')) :
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('lastname');
                $table->string('email')->unique();
                $table->timestamps('email_verified_at', 0)->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->enum('active', ['Y', 'N'])->default('Y');
                $table->integer('roles_id')->unsigned()->default(1);
                $table->integer('image_id')->unsigned()->nullable();
                $table->enum('social', ['Y', 'N'])->default('N');
                $table->text('avatar')->nullable();
                $table->timestamps();

                $table->foreign('roles_id')->references('id')->on('roles');
                $table->foreign('image_id')->references('id')->on('files');
            });
        else :
            Schema::table('users', function (Blueprint $table) {
                $table->string('lastname')->after('name');
                $table->enum('active', ['Y', 'N'])->default('N')->after('remember_token');
                $table->integer('roles_id')->unsigned()->default(1)->after('active');
                $table->integer('image_id')->unsigned()->nullable()->after('roles_id');
                
                $table->foreign('roles_id')->references('id')->on('roles');
                $table->foreign('image_id')->references('id')->on('files');
            });
        endif;

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
