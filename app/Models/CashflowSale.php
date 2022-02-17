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

class CashflowSale extends Model implements HasMedia
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use InteractsWithMedia;
    use HasFactory;

    public const IS_INCOME_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public const IS_ACTIVE_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public const IS_PROBLEM_SELECT = [
        'yes' => 'Yes',
        'no'  => 'No',
    ];

    public $table = 'cashflow_sales';

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
        'packing_code_id',
        'sales_qty',
        'unit_id',
        'unit_price',
        'discount',
        'total_price',
        'is_income',
        'is_active',
        'is_problem',
        'is_priority_id',
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

    public function packing_code()
    {
        return $this->belongsTo(Packing::class, 'packing_code_id');
    }

    public function unit()
    {
        return $this->belongsTo(UnitWeight::class, 'unit_id');
    }

    public function tags()
    {
        return $this->belongsToMany(AttTag::class);
    }

    public function is_priority()
    {
        return $this->belongsTo(AttPriority::class, 'is_priority_id');
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

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->number = CashflowSale::whereYear('created_at', Carbon::now()->year)->where('team_id', $model->team_id)->max('number') + 1; // start from 1 every year
            $model->code = 'CFS' . str_pad($model->number, 5, '0', STR_PAD_LEFT)
            ;
        });
    }
}
