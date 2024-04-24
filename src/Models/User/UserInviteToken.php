<?php

namespace HibridVod\Database\Models\User;

use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Contracts\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use HibridVod\Database\Models\Traits\Uuidable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HibridVod\Database\Repository\Contracts\EntityInterface;

/**
 * Class UserInviteToken
 * @package HibridVod\Database\Models\User
 */
class UserInviteToken extends BaseModel implements HasUuid, EntityInterface
{
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
    protected $table = 'user_invite_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $token
     *
     * @return \HibridVod\Database\Models\User\UserInviteToken
     */
    public function findByToken(string $token): UserInviteToken
    {
        // @phpstan-ignore-next-line
        return $this->newQuery()->whereToken($token)->firstOrFail();
    }
}
