<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertisementTagsSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create('advertisement_tags', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('tag');
            $table->string('title');
            $table->string('type');
            $table->uuid('created_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();

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
        $this->dropIfExists('advertisement_tags');
    }
}
