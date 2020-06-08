<?php


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ModelHasRoles extends Pivot
{
    protected $table      = 'model_has_roles';
    protected $primaryKey = ['role_id', 'model_type', 'model_id'];
    public    $timestamps = false;

    /**
     * Get all of the owning modelable model.
     */
    public function modelable()
    {
        return $this->morphTo();
    }
}
