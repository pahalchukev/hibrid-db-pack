<?php

namespace HibridVod\Database\Models\User;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\Tenant\Tenant;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Models\User\Observers\UserObserver;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * HibridVod\Database\Models\User
 *
 * @property int                                             $id
 * @property string                                          $username
 * @property string                                          $first_name
 * @property string                                          $last_name
 * @property string                                          $email
 * @property string|null                                     $profile
 * @property string                                          $wms_prefix
 * @property int                                             $tenant_id
 * @property bool                                            $is_active
 * @property bool                                            $is_root
 * @property string                                          $password
 * @property Carbon|null                                     $created_at
 * @property Carbon|null                                     $updated_at
 * @property string|null                                     $deleted_at
 * @property \HibridVod\Database\Models\User\Role            $role
 * @property \HibridVod\Database\Models\User\UserInviteToken $user_invite_token
 * @method static Builder|User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin BaseModel
 */
class User extends BaseModel implements HasUuid, EntityInterface
{
    use UsesSystemConnection;
    use SoftDeletes;
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
     * Default table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'tenant_id',
        'role_id',
        'two_factor_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret'
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        static::observe(UserObserver::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function inviteToken(): HasOne
    {
        return $this->hasOne(UserInviteToken::class, 'user_id');
    }

    /**
     * @param \Spatie\Permission\Contracts\Permission|int|string $permission
     *
     * @return bool
     */
    public function checkPermissionTo($permission): bool
    {
        return $this->is_root || $this->role->hasPermissionTo($permission);
    }

    /**
     * @return string
     */
    protected function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
