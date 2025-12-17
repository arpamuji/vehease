<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Parables\Cuid\CuidAsPrimaryKey;

/**
 * @property string $id
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property string $note
 * @property string $vehicle_id
 * @property string $driver_id
 * @property string $requester_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereRequesterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereVehicleId($value)
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use CuidAsPrimaryKey;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'start_date',
        'end_date',
        'vehicle_id',
        'driver_id',
        'requester_id',
        'note',
        'status',
    ];

    // Relationships
    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
