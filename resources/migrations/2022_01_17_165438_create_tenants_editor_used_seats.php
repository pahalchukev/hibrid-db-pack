<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTenantsEditorUsedSeats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('tenant_editor_used_seats', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('tenant_id');
            $table->foreign('tenant_id')
                ->on('tenants')
                ->references('id')
                ->onDelete('cascade');

            $table->uuid('video_id');
            $table->foreign('video_id')
                ->on('videos')
                ->references('id')
                ->onDelete('cascade');

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropIfExists('tenant_editor_used_seats');
    }
}
