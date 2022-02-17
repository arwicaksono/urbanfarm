<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesLabel extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;

    public $table = 'sales_labels';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'unit_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitQuantity::class, 'unit_id');
    }

    public function companies()
    {
        return $this->belongsToMany(PurchaseCompany::class);
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
