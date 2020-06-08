<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CorporationService extends Pivot
{
    protected $table      = 'corporation_service';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'corporation_id',
            'service_id',
            'status',
            'reason',
        ];
    protected $dates
                          = [
            'created_at',
            'updated_at',
            'terminated_at',
        ];

    /**
     * Get status by corporationID
     *
     * @param $corporation_id
     * @param $service_id
     * @return mixed
     */
    public static function findByCorporationID($corporation_id, $service_id)
    {
        return (new static)->where('corporation_id', $corporation_id)
            ->where('service_id', $service_id)
            ->first();
    }
}
