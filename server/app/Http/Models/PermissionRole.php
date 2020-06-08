<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    protected $table      = 'permission_role';
    protected $primaryKey = ['permission_id', 'role_id'];
    protected $fillable
                          = [
            'level',
        ];
    public    $timestamps = false;
}
