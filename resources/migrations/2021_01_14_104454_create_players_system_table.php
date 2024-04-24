<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('type');
            $table->json('options')->nullable();
            $table->boolean('is_default')->default(false);
            $table->uuid('advertisement_tag_id')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('advertisement_tag_id')
                ->references('id')
                ->on('advertisement_tags')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->dropIfExists('players');
    }
}
