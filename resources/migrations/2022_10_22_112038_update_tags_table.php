<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class UpdateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->string('color')->nullable()->change();
            $table->string('category')->default('tags');
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('tags_created_by_foreign');
            }
            $table->dropColumn('created_by');
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('tags_tenant_id_foreign');
            }
            $table->index(['tenant_id', 'category']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropColumn('category');
                $table->dropIndex('tags_tenant_id_category_index');

                $table->foreign('created_by')->references('id')->on('users');
                $table->string('created_by');

                $table->foreign('tenant_id')->references('id')->on('tenants');
            }

        });
    }
}
