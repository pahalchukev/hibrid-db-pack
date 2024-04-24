<?php

namespace HibridVod\Database\Models\Audit;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Models\Audit as AuditBase;

class Audit extends AuditBase
{
    use SoftDeletes;

    /**
     * @var array<string>
     */
    protected $appends = [
        'relation_title',
        'auditable_type_custom',
    ];

    public static function bootSoftDeletes(): void
    {
    }

    /**
     *
     * @return false|mixed|string
     */
    public function getAuditableTypeCustomAttribute()
    {
        $arr = explode("\\", $this->auditable_type);
        return end($arr);
    }

    /**
     *
     * @return string
     */
    public function getRelationTitleAttribute(): string
    {
        $value = explode("\\", $this->auditable_type);
        /** @var string $class_name */
        $class_name = str_replace('\\', "\\", $this->auditable_type);

        switch (end($value)) {
            case "LiveStream":
                // @phpstan-ignore-next-line
                $rel = $this->belongsTo($class_name, 'auditable_id')->withTrashed()
                    ->first()
                    ->stream_name ?? 'N/A';
                break;
            case "RemoteVideo":
                $rel = $this->title ?? 'N/A';
                break;
            default:
                // @phpstan-ignore-next-line
                $rel = $this->belongsTo($class_name, 'auditable_id')->withTrashed()
                    ->first()
                    ->title ?? 'N/A';
                break;
        }

        return $rel;
    }
}
