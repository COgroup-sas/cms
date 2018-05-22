<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCogModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->connection()->getSchemaBuilder();

        if (!$schema->hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->increments('id');
                $table->string('moduleslug', 100);
                $table->string('modulename');
                $table->text('description');
                $table->enum('active', ['Y', 'N'])->default('Y');
                $table->string('url');
                $table->string('icon', 50);
                $table->tinyInteger('parent')->default('0');
                $table->tinyInteger('order')->default('0');
                $table->enum('inmenu', ['Y', 'N'])->default('Y');
                $table->string('permissions', 100);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
