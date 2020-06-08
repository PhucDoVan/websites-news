<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table      = 'groups';
    protected $primaryKey = 'id';
    protected $fillable
                          = [
            'name',
            'corporation_id',
            'parent_group_id'
        ];

    /**
     * Get the corporation that owns the group.
     */
    public function corporation()
    {
        return $this->belongsTo('App\Http\Models\Corporation', 'corporation_id');
    }

    /**
     * Get the accounts for the group.
     */
    public function accounts()
    {
        return $this->hasMany('App\Http\Models\Account', 'group_id');
    }

    /**
     * Get the registries for the group.
     */
    public function registries()
    {
        return $this->hasMany('App\Http\Models\Registry', 'group_id');
    }

    /**
     * Get the parent group that owns the group.
     */
    public function parentGroup()
    {
        $this->belongsTo('App\Http\Models\Group','parent_group_id');
    }

    /**
     * Get the child groups.
     *
     * @return string
     */
    public function childs() {
        return $this->hasMany('App\Http\Models\Group','parent_group_id','id') ;
    }
}
