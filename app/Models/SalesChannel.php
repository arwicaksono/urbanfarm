<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesChannel extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;

    public const SALES_TYPE_SELECT = [
        'online'  => 'Online',
        'offline' => 'Offline',
    ];

    public $table = 'sales_channels';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'sales_type',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
