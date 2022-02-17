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

class CareModule extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_DONE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'care_modules';

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
        'problem_mo_id',
        'action',
        'date',
        'time_start',
        'time_end',
        'efficacy_id',
        'status_id',
        'is_done',
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

    public function problem_mo()
    {
        return $this->belongsTo(ModuleObservation::class, 'problem_mo_id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function efficacy()
    {
        return $this->belongsTo(AttEfficacy::class, 'efficacy_id');
    }

    public function status()
    {
        return $this->belongsTo(AttStatus::class, 'status_id');
    }

    public function tags()
    {
        return $this->belongsToMany(AttTag::class);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
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

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->number = CareModule::whereYear('created_at', Carbon::now()->year)->where('team_id', $model->team_id)->max('number') + 1; // start from 1 every year
            $model->code = 'CMD' . str_pad($model->number, 4, '0', STR_PAD_LEFT);
        });
    }
}
