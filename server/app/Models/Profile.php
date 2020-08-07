<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Profile extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'profiles';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';

    protected $fillable
        = [
            'user_id',
            'full_name',
            'avatar',
            'phone',
            'facebook',
            'google',
            'twitter',
            'birthday',
        ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
