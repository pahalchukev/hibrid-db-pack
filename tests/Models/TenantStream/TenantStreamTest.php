<?php

namespace HibridVod\Database\Tests\Models\TenantStream;

use HibridVod\Database\Models\Cast\Cast;
use HibridVod\Database\Models\Channel\Channel;
use HibridVod\Database\Models\TenantStream\TenantStream;
use HibridVod\Database\Models\Player\Player;

use HibridVod\Database\Models\Pivot\ChannelBreakVideo;
use HibridVod\Database\Models\Tag\Tag;
use HibridVod\Database\Models\Traits\ExtraEventsTrait;
use HibridVod\Database\Models\Traits\HasDefaultRelations;
use HibridVod\Database\Models\Traits\HasTenantId;
use HibridVod\Database\Models\Traits\UsesSystemConnection;
use HibridVod\Database\Models\Traits\Uuidable;
use HibridVod\Database\Models\Video\Video;
use HibridVod\Database\Tests\Models\Traits\HasDefaultRelationsAsserts;
use HibridVod\Database\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use OwenIt\Auditing\Auditable as AuditableTrait;

class TenantStreamTest extends TestCase
{
    use DatabaseMigrations, HasDefaultRelationsAsserts;

    private TenantStream $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = factory(TenantStream::class)->create();
    }

    /** @test */
    public function it_should_use_system_connection(): void
    {
        self::assertHasSystemConnection($this->model);
    }

    /** @test */
    public function it_should_have_uuid_id(): void
    {
        self::assertModelHasStringIdentifier($this->model);
    }

    /** @test */
    public function it_should_have_fillable_attributes(): void
    {
        self::assertModelHasFillableColumns($this->model, [
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
            'comments'
        ]);
    }

    /** @test */
    public function it_should_have_list_of_traits(): void
    {
        self::assertModelHasTraits($this->model, [
            UsesSystemConnection::class,
            HasDefaultRelations::class,
            SoftDeletes::class,
            Uuidable::class,
            AuditableTrait::class,
            HasTenantId::class,
        ]);
    }

    /** @test */
    public function it_should_have_player_relation(): void
    {
        self::assertInstanceOf(Player::class, $this->model->player);
        self::assertModelRelationKeys($this->model->player(), 'player_id');
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }
}
