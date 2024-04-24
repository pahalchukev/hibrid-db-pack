<?php

use HibridVod\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleAndPermissionSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->create($this->tableName('permissions'), static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('group');
            $table->string('guard_name');
            $table->timestamps();
            $table->softDeletes();
        });

        $this->create($this->tableName('roles'), static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('alias');
            $table->string('guard_name');
            $table->uuid('tenant_id');
            $table->boolean('is_reserved')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['alias', 'tenant_id']);

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
        });

        $this->create($this->tableName('role_has_permissions'), function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->uuid('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($this->tableName('permissions'))
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($this->tableName('roles'))
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->drop($this->tableName('role_has_permissions'));
        $this->drop($this->tableName('roles'));
        $this->drop($this->tableName('permissions'));
    }

    /**
     * @param string $tableName
     *
     * @return string
     */
    private function tableName(string $tableName): string
    {
        return config('permission.table_names.' . $tableName, $tableName);
    }
}
