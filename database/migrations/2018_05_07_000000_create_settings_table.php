<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app('db')->connection('mysql')->getSchemaBuilder();

        if (!$schema->hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('setting');
                $table->string('defaultvalue');
            });
        }

        if (!$schema->hasTable('noworkingdays')) {
            Schema::create('noworkingdays', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->date('date');
                $table->enum('active', ['Y', 'N'])->default('Y');
                $table->timestamps();

                $table->index('date');
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
        Schema::dropIfExists('noworkingdays');
        Schema::dropIfExists('settings');
    }
}
