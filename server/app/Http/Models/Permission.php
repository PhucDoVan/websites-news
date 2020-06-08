<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table      = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'service_id',
            'label',
            'name',
        ];

    /**
     * Get the service that owns the permission.
     */
    public function service()
    {
        return $this->belongsTo('App\Http\Models\Service', 'service_id');
    }

    /**
     * The roles that belong to the permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')
            ->using('App\Http\Models\PermissionRole')
            ->withPivot('level');
    }
}
