<?php

namespace HibridVod\Database;

use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\AuditingServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/config.php' => config_path('hibrid-vod.database.php'),
        ], 'hibrid-vod.database');

        $this->mergeConfigFrom(__DIR__ . '/../resources/config.php', 'hibrid-vod.database');

        if ($this->app->get('config')->get('hibrid-vod.database.execute_migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/../resources/migrations/');

            $this->loadFactoriesFrom(__DIR__ . '/../resources/factories/');
        }

        $this->app->register(AuditingServiceProvider::class);

        $this->prepareModelAttributes();
    }

    protected function prepareModelAttributes(): void
    {
        $config = $this->app['config']->get('hibrid-vod.database');
        /** @var \HibridVod\Database\Models\BaseModel $model */

        foreach (($config['attributes']['hidden'] ?? []) as $model => $attributes) {
            if (class_exists($model)) {
                $model::hideAttributes($attributes);
            }
        }

        foreach (($config['attributes']['appends'] ?? []) as $model => $attributes) {
            if (class_exists($model)) {
                $model::includeAttributes($attributes);
            }
        }

        foreach (($config['relations']['include'] ?? []) as $model => $attributes) {
            if (class_exists($model)) {
                $model::includeRelations($attributes);
            }
        }
    }
}
