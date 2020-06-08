<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRestrict extends Model
{
    use SoftDeletes;

    protected $table      = 'service_restricts';
    protected $primaryKey = 'service_restrict_id';
    protected $fillable   = ['account_id', 'type', 'value'];

    public function account()
    {
        return $this->belongsTo('App\Http\Models\Account', 'account_id');
    }
}
