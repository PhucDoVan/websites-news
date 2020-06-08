<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'service_id',
            'label',
            'name',
        ];

    /**
     * Get the service that owns the role.
     */
    public function service()
    {
        return $this->belongsTo('App\Http\Models\Service', 'service_id');
    }

    /**
     * The permissions that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')
            ->using('App\Http\Models\PermissionRole')
            ->withPivot('level');
    }

    /**
     * Get all of the accounts that are assigned this role.
     */
    public function accounts()
    {
        return $this->morphedByMany('App\Http\Models\Account', 'model', 'model_has_roles');
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function findByName($name)
    {
        return (new static)->where('name', $name)->first();
    }
}
