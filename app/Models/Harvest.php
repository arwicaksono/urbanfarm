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

class Harvest extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_ACTIVE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public const IS_PROBLEM_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'harvests';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'number',
        'date',
        'time',
        'plot_id',
        'age',
        'unit_id',
        'round',
        'harvest_qty',
        'harvest_unit_id',
        'status_id',
        'is_active',
        'is_problem',
        'priority_id',
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

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function plot()
    {
        return $this->belongsTo(Plot::class, 'plot_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitAge::class, 'unit_id');
    }

    public function grades()
    {
        return $this->belongsToMany(ProductGrade::class);
    }

    public function harvest_unit()
    {
        return $this->belongsTo(UnitQuantity::class, 'harvest_unit_id');
    }

    public function status()
    {
        return $this->belongsTo(AttStatus::class, 'status_id');
    }

    public function tags()
    {
        return $this->belongsToMany(AttTag::class);
    }

    public function priority()
    {
        return $this->belongsTo(AttPriority::class, 'priority_id');
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

    public function person_in_charges()
    {
        return $this->belongsToMany(User::class);
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
