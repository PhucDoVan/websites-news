<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporationContact extends Model
{
    use SoftDeletes;

    protected $table      = 'corporation_contacts';
    protected $primaryKey = 'corporation_contact_id';
    protected $fillable
                          = [
            'corporation_id',
            'name',
            'tel',
            'email',
            'fax'
        ];

    /**
     * Get the corporation that owns the contact.
     */
    public function corporation()
    {
        return $this->belongsTo('App\Http\Models\Corporation', 'corporation_id');
    }
}
