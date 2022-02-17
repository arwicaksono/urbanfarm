<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlotVariety extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;

    public $table = 'plot_varieties';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'brand_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function brand()
    {
        return $this->belongsTo(PurchaseBrand::class, 'brand_id');
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
