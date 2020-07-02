<?php

namespace App;

use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'remember_me',
    ];

    protected $date = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function profiles()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }
}
