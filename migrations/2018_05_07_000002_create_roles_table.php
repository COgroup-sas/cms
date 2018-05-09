<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $schema = app('db')->connection()->getSchemaBuilder();

    if (!$schema->hasTable('roles')) {
      Schema::create('roles', function (Blueprint $table) {
        $table->increments('id');
        $table->string('rolname');
        $table->string('description', 255);
        $table->timestamps();

        $table->index('rolname');
      });
    }

    if (!$schema->hasTable('roles_access')) {
      Schema::create('roles_access', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('roles_id')->unsigned();
        $table->integer('modules_id')->unsigned();
        $table->tinyInteger('view')->default('0');
        $table->tinyInteger('create')->default('0');
        $table->tinyInteger('update')->default('0');
        $table->tinyInteger('delete')->default('0');
        $table->timestamps();

        $table->foreign('roles_id')->references('id')->on('roles');
        $table->foreign('modules_id')->references('id')->on('modules');
      });
    }

    Schema::enableForeignKeyConstraints();
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('roles_access');
    Schema::dropIfExists('roles');
  }
}
