<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table      = 'services';
    protected $primaryKey = 'id';
    protected $fillable   = ['name', 'token'];
    protected $dates
                          = [
            'created_at',
            'updated_at',
        ];

    /**
     * Get the tokens for the service.
     */
    public function tokens()
    {
        return $this->hasMany('App\Http\Models\Token', 'service_id');
    }

    /**
     * The services that belong to the corporation.
     */
    public function corporations()
    {
        return $this->belongsToMany(Corporation::class, 'corporation_service', 'service_id', 'corporation_id')
            ->using('App\Http\Models\CorporationService')
            ->withPivot(['status', 'reason', 'terminated_at']);
    }

    /**
     * Get the roles for the service.
     */
    public function roles()
    {
        return $this->hasMany('App\Http\Models\Role', 'service_id');
    }

    /**
     * Get the permissions for the service.
     */
    public function permissions()
    {
        return $this->hasMany('App\Http\Models\Permission', 'service_id');
    }
}
