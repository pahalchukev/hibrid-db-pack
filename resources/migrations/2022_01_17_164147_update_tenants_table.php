<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->table('tenants', function (Blueprint $table) {
            $table->integer('editor_seats')->nullable()->after('contact_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->table('tenants', function (Blueprint $table) {
            $table->dropColumn('editor_seats');
        });
    }
}
