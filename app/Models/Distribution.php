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

class Distribution extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_PROBLEM_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'distributions';

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
        'customer_id',
        'channel_id',
        'market_id',
        'delivery_id',
        'cost',
        'status_id',
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

    public function packing_codes()
    {
        return $this->belongsToMany(Packing::class);
    }

    public function customer()
    {
        return $this->belongsTo(SalesCustomer::class, 'customer_id');
    }

    public function channel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id');
    }

    public function market()
    {
        return $this->belongsTo(SalesMarket::class, 'market_id');
    }

    public function delivery()
    {
        return $this->belongsTo(SalesDelivery::class, 'delivery_id');
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
