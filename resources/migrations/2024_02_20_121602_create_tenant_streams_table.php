<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_streams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('created_by')->nullable();
            $table->string('title', 255);
            $table->json('title_trans')->nullable();
            $table->text('description')->nullable();
            $table->json('description_trans')->nullable();
            $table->string('channel_title', 150);
            $table->string('channel_logo', 155);
            $table->string('origin_server_url', 255);
            $table->string('rtmp_source', 255);
            $table->string('cdn_cname', 255);
            $table->string('cdn_client_app', 255);
            $table->string('stream_app', 255);
            $table->string('hls_manifest', 255)->default('playlist.m3u8');
            $table->string('mpd_manifest', 255)->default('manifest.mpd');
            $table->string('poster', 155);
            $table->string('logo', 155);
            $table->string('channel_key', 45);
            $table->text('embed_code');
            $table->string('monitoring_url', 255)->nullable();
            $table->string('preview_url', 255)->nullable();
            $table->boolean('audio_only')->default(false);
            $table->text('info_text')->nullable();
            $table->text('info_title')->nullable();
            $table->string('preroll_type')->nullable();
            $table->text('ima_ad_tag')->nullable();
            $table->text('ima_ad_params')->nullable();
            $table->boolean('dai_enabled')->default(false);
            $table->string('dai_api_key', 100)->nullable();
            $table->string('dai_asset_key', 100)->nullable();
            $table->boolean('with_credentials')->default(false);
            $table->unsignedInteger('lln_ttl')->nullable();
            $table->string('lln_secret', 100)->nullable();
            $table->string('url_algorithm', 5)->nullable();
            $table->string('stream_url', 255)->nullable();
            $table->string('llhls_url', 255)->nullable();
            $table->boolean('ga_tracking_enabled')->default(false);
            $table->string('ga_tracking_id', 45)->nullable();
            $table->boolean('thumbnails_enabled')->default(false);
            $table->text('thumbnails_config')->nullable();
            $table->uuid('player_id')->nullable();
            $table->unsignedInteger('dvr_duration')->nullable();
            $table->text('ssai_params')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('player_id')
                ->references('id')
                ->on('players')
                ->onDelete('set null');

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
    public function down()
    {
        Schema::dropIfExists('tenant_streams');
    }
}
