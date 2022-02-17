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

class CarePreOrder extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const PAYMENT_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public const IS_DONE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'care_pre_orders';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'date',
        'date_due',
        'date_delivery',
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
        'product_id',
        'qty',
        'unit_id',
        'date_due',
        'time_due',
        'priority_id',
        'date_delivery',
        'time_delivery',
        'payment',
        'is_done',
        'created_at',
        'note',
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

    public function customer()
    {
        return $this->belongsTo(SalesCustomer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(PlotPlant::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitQuantity::class, 'unit_id');
    }

    public function getDateDueAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateDueAttribute($value)
    {
        $this->attributes['date_due'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function tags()
    {
        return $this->belongsToMany(AttTag::class);
    }

    public function priority()
    {
        return $this->belongsTo(AttPriority::class, 'priority_id');
    }

    public function getDateDeliveryAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateDeliveryAttribute($value)
    {
        $this->attributes['date_delivery'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
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
