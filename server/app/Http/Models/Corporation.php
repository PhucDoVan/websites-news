<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Corporation extends Model
{
    use SoftDeletes;

    protected $table      = 'corporations';
    protected $primaryKey = 'corporation_id';
    protected $fillable
                          = [
            'name',
            'kana',
            'uid',
            'postal',
            'address_pref',
            'address_city',
            'address_town',
            'address_etc'
        ];
    protected $dates
                          = [
            'created_at',
            'updated_at',
        ];

    /**
     * Get the accounts for the corporation.
     */
    public function accounts()
    {
        return $this->hasMany('App\Http\Models\Account', 'corporation_id');
    }

    /**
     * Get the contact for the corporation.
     */
    public function contacts()
    {
        return $this->hasMany('App\Http\Models\CorporationContact', 'corporation_id');
    }

    /**
     * Get the groups for the corporation.
     */
    public function groups()
    {
        return $this->hasMany('App\Http\Models\Group', 'corporation_id');
    }

    /**
     * The services that belong to the corporation.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'corporation_service', 'corporation_id', 'service_id')
            ->using('App\Http\Models\CorporationService')
            ->withPivot(['status', 'reason', 'terminated_at']);
    }

    /**
     * Get the registries for the corporation.
     */
    public function registries()
    {
        return $this->hasMany('App\Http\Models\Registry', 'corporation_id');
    }

    /**
     * @param $uid
     * @return mixed
     */
    public static function findByUID($uid)
    {
        return (new static)->where('uid', $uid)->first();
    }
}
