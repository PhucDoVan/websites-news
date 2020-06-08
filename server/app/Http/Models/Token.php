<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table      = 'tokens';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'account_id',
            'service_id',
            'token',
            'expires_in',
        ];
    protected $dates
                          = [
            'created_at',
            'updated_at',
            'expires_in',
        ];

    public function account()
    {
        return $this->belongsTo('App\Http\Models\Account', 'account_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Http\Models\Service', 'service_id');
    }
}