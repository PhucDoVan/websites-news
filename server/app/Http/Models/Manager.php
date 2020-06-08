<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table      = 'managers';
    protected $primaryKey = 'manager_id';
    protected $fillable   = ['name', 'username', 'password'];
    protected $hidden     = ['password'];

    /**
     * Overrides the method to ignore the remember token.
     *
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if ( ! $isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }
}
