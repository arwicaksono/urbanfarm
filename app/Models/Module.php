<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class Module extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_ACTIVE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'modules';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'number',
        'site_code_id',
        'system_id',
        'lighting_id',
        'reservoir_id',
        'pump_id',
        'mounting_id',
        'capacity',
        'unit_id',
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

    public function site_code()
    {
        return $this->belongsTo(Site::class, 'site_code_id');
    }

    public function system()
    {
        return $this->belongsTo(ModuleSystem::class, 'system_id');
    }

    public function lighting()
    {
        return $this->belongsTo(ModuleComponent::class, 'lighting_id');
    }

    public function reservoir()
    {
        return $this->belongsTo(ModuleComponent::class, 'reservoir_id');
    }

    public function pump()
    {
        return $this->belongsTo(ModuleComponent::class, 'pump_id');
    }

    public function mounting()
    {
        return $this->belongsTo(ModuleComponent::class, 'mounting_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitCapacity::class, 'unit_id');
    }

    public function acitivities()
    {
        return $this->belongsToMany(ModuleActivity::class);
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

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->number = Module::whereYear('created_at', Carbon::now()->year)->where('team_id', $model->team_id)->max('number') + 1; // start from 1 every year
            $model->code = 'MOD' . str_pad($model->number, 4, '0', STR_PAD_LEFT)
            ;
        });
    }
}
