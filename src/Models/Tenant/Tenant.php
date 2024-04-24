<?php

namespace HibridVod\Database\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use HibridVod\Database\Models\User\User;
use HibridVod\Database\Models\TenantStream\TenantStream;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use HibridVod\Database\Models\Tenant\Instances\Config;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class Tenant
 * @package HibridVod\Database\Models\Tenant
 * @property string $alias
 */
class Tenant extends Model implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use Uuidable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<string>
     */
    protected $fillable = [
        'logo',
        'name',
        'alias',
        'favico',
        'config',
        'contact_information',
        'is_active',
        'secrets',
        'editor_seats',
        'live_stream_seats',
        'playout_seats',
    ];

    /**
     * @var array<string>
     */
    protected $hidden = [
        'config',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'contact_information' => 'json',
        'secrets'             => 'json',
        'config'              => 'json',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \HibridVod\Database\Models\Tenant\Instances\Config
     */
    public function getConfigInstance(): Config
    {
        return new Config($this->config ?? []);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function streams(): HasMany
    {
        return $this->hasMany(TenantStream::class);
    }
}
