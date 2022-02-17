<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Plot extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_ACTIVE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'plots';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'number',
        'plot_prefix_id',
        'activity_id',
        'module_id',
        'nutrient_brand_id',
        'plot_qty',
        'unit_id',
        'variety_id',
        'date_start',
        'time_start',
        'date_end',
        'time_end',
        'is_active',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function plot_prefix()
    {
        return $this->belongsTo(PlotCode::class, 'plot_prefix_id');
    }

    public function activity()
    {
        return $this->belongsTo(PlotStage::class, 'activity_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function nutrient_brand()
    {
        return $this->belongsTo(PurchaseBrand::class, 'nutrient_brand_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitQuantity::class, 'unit_id');
    }

    public function variety()
    {
        return $this->belongsTo(PlotVariety::class, 'variety_id');
    }

    public function getDateStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function tags()
    {
        return $this->belongsToMany(AttTag::class);
    }

    public function getImageAttribute()
    {
        $files = $this->getMedia('image');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
