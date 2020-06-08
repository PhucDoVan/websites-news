<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Account extends Authenticatable
{
    use Notifiable, SoftDeletes;
    use HasRelationships;

    protected $table      = 'accounts';
    protected $primaryKey = 'account_id';
    protected $fillable
                          = [
            'username',
            'password',
            'corporation_id',
            'group_id',
            'name_last',
            'name_first',
            'kana_last',
            'kana_first',
            'email',
            't_service_id'
        ];
    protected $dates
                          = [
            'created_at',
            'updated_at',
            'shikakumap_registered_at',
            'shikakumap_deregistered_at'
        ];
    protected $hidden     = ['password'];

    /**
     * Get the corporation that owns the account.
     */
    public function corporation()
    {
        return $this->belongsTo('App\Http\Models\Corporation', 'corporation_id');
    }

    /**
     * Get the group that owns the account.
     */
    public function group()
    {
        return $this->belongsTo('App\Http\Models\Group', 'group_id');
    }

    /**
     * Get the restricts for the account.
     */
    public function restricts()
    {
        return $this->hasMany('App\Http\Models\ServiceRestrict', 'account_id');
    }

    /**
     * Get the tokens for the account.
     */
    public function tokens()
    {
        return $this->hasMany('App\Http\Models\Token', 'account_id');
    }

    /**
     * Get the registries for the account.
     */
    public function registries()
    {
        return $this->hasMany('App\Http\Models\Registry', 'account_id');
    }

    /**
     * Get all of the roles for the account.
     */
    public function roles()
    {
        return $this->morphToMany('App\Http\Models\Role', 'model', 'model_has_roles');
    }

    /**
     * Get all of the permissions for the account.
     *
     * @return HasManyDeep
     */
    public function permissions()
    {
        return $this->hasManyDeep(
            Permission::class,
            ['model_has_roles', Role::class, PermissionRole::class],
            [['model_type', 'model_id'], 'id'],
            [null, 'role_id']
        )->withIntermediate(PermissionRole::class, ['level']);
    }

    /**
     * Get a account by username (check exists username)
     *
     * @param $username
     * @return mixed
     */
    public static function findByUsername($username)
    {
        return (new static)->where('username', $username)->first();
    }
}
