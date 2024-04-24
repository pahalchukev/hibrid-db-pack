<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_custom_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('video_id');
            $table->uuid('custom_field_id');

            $table->dateTime('date')->nullable();
            $table->string('string')->nullable();
            $table->text('text')->nullable();
            $table->boolean('boolean')->nullable();
            $table->json('json')->nullable();

            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade');

            $table->foreign('custom_field_id')
                ->references('id')
                ->on('custom_fields')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_custom_fields');
    }
}
