<?php

namespace HibridVod\Database\Models\TenantStream;

use HibridVod\Database\Contracts\HasUuid;
use HibridVod\Database\Models\BaseModel;
use HibridVod\Database\Models\Player\Player;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Repository\Contracts\EntityInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class TenantStream extends BaseModel implements HasUuid, EntityInterface, Auditable
{
    use UsesSystemConnection;
    use HasDefaultRelations;
    use SoftDeletes;
    use Uuidable;
    use AuditableTrait;
    use HasTenantId {
        HasTenantId::transformAudit insteadof AuditableTrait;
    }

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
        'created_by',
        'tenant_id',
        'title',
        'title_trans',
        'description',
        'description_trans',
        'channel_title',
        'channel_logo',
        'origin_server_url',
        'rtmp_source',
        'cdn_cname',
        'cdn_client_app',
        'stream_app',
        'hls_manifest',
        'mpd_manifest',
        'poster',
        'logo',
        'channel_key',
        'embed_code',
        'monitoring_url',
        'preview_url',
        'audio_only',
        'info_text',
        'info_title',
        'preroll_type',
        'ima_ad_tag',
        'ima_ad_params',
        'dai_enabled',
        'dai_api_key',
        'dai_asset_key',
        'with_credentials',
        'lln_ttl',
        'lln_secret',
        'url_algorithm',
        'stream_url',
        'llhls_url',
        'ga_tracking_enabled',
        'ga_tracking_id',
        'thumbnails_enabled',
        'thumbnails_config',
        'player_id',
        'dvr_duration',
        'ssai_params',
        'comments',
    ];

    /**
     * @var array<string>
     */
    protected $appends = ['hls_link'];


    /**
     * @return BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return string
     */
    public function getHlsLinkAttribute(): string
    {
        // if url algorithm is std, return stream_url
        // if url algorithm is lln, build it using hashsecret and cookies
        // if url algorithm is llnpb, build it using pathbased algorithm

        if ($this->url_algorithm == 'lln') {
            $secret = $this->lln_secret;
            // $baseUrl = 'https://' . $this->cdn_cname . '/' . $this->cdn_client_app . '/' . $this->stream_app . '/';
            $baseUrl = $this->baseUrl;
            $startTime = time();
            $endTime = time() + $this->lln_ttl;
            $p = strlen($baseUrl);
            $queryString = '?p=' . $p . '&s=' . $startTime . '&e=' . $endTime . '&cf=' . $endTime;
            $hash = md5($secret . $baseUrl . $queryString);
            $playlistUrl = $baseUrl . $this->hls_manifest . $queryString . '&h=' . $hash;
            return $playlistUrl;
        } elseif ($this->url_algorithm == 'llnpb') {
            $secret = $this->lln_secret;
            $baseUrl = 'https://' . $this->cdn_cname
                . '/' . $this->cdn_client_app . '/' . $this->stream_app . '/' . $this->stream_app . '/';
            $url_file = $this->hls_manifest;

            $hours = 12;
            $token_name = 'token';
            $token_delim = '~';

            $prefix_length = strlen($baseUrl);
            $expiry = time() + ($hours * 3600);

            $hash_data = $secret . $baseUrl . '?p=' . $prefix_length . '&e=' . $expiry;
            $token_hash = md5(utf8_encode($hash_data));

            $token = 'p=' . $prefix_length . $token_delim . 'e=' . $expiry . $token_delim . 'h=' . $token_hash;
            $playlistUrl = $baseUrl . $token_name . '=' . $token . '/' . $url_file;
            return $playlistUrl;
        } else {
            return ($this->monitoring_url == null || $this->monitoring_url == '')
                ? $this->baseUrl . $this->hls_manifest : $this->monitoring_url;
        }
    }

    /**
     * @return string
     */
    public function getBaseUrlAttribute(): string
    {
        $baseUrl = 'https://' . $this->cdn_cname . '/' . $this->cdn_client_app . '/' . $this->stream_app . '/';
        return $baseUrl;
    }
}
