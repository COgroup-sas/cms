<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCogFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->connection('mysql')->getSchemaBuilder();

        if (!$schema->hasTable('files')) :
            Schema::create('files', function (Blueprint $table) {
                $table->increments('id');
                $table->string('originalname');
                $table->string('diskname');
                $table->string('extension');
                $table->string('size');
                $table->string('mimetype');
                $table->integer('width');
                $table->integer('height');
                $table->enum('ispublic', ['0', '1'])->default('1');
                $table->timestamps();
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
        Schema::dropIfExists('files');
    }
}
