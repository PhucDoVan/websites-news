<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registry extends Model
{
    use SoftDeletes;

    protected $table      = 'registries';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'corporation_id',
            'group_id',
            'account_id',
            'label',
            'v1_code',
            'number_type',
            'number',
            'pdf_type',
            's3_object_url',
            'requested_at',
            'based_at',
            'latitude',
            'longitude',
        ];

    /**
     * Get the corporation that owns the registry.
     */
    public function corporation()
    {
        return $this->belongsTo('App\Http\Models\Corporation', 'corporation_id');
    }

    /**
     * Get the group that owns the registry.
     */
    public function group()
    {
        return $this->belongsTo('App\Http\Models\Group', 'group_id');
    }

    /**
     * Get the account that owns the registry.
     */
    public function account()
    {
        return $this->belongsTo('App\Http\Models\Account', 'account_id');
    }
}
