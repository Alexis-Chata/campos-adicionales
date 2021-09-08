<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info_fields', function (Blueprint $table) {
            $table->id();
            $table->string('shortname');
            $table->longText('name');
            $table->string('dataype');
            $table->longText('description')->nullable();
            $table->tinyInteger('descriptionformat');
            $table->bigInteger('sortorder');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->tinyInteger('require');
            $table->tinyInteger('locked');
            $table->smallInteger('visible');
            $table->tinyInteger('forceunique');
            $table->tinyInteger('signup');
            $table->longText('defaultdata')->nullable();
            $table->tinyInteger('defaultdataformat');
            $table->longText('param1')->nullable();
            $table->longText('param2')->nullable();
            $table->longText('param3')->nullable();
            $table->longText('param4')->nullable();
            $table->longText('param5')->nullable();
            $table->timestamps();
            /*crear la relacion*/
            $table->foreign('category_id')->references('id')
            ->on('user_info_categories')
            ->onDelete('set null')
            ->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info_fields');
    }
}
