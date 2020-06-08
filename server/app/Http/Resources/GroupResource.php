<?php

namespace App\Http\Resources;

use App\Http\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GroupResource
 *
 * @package App\Http\Resources
 * @mixin Group
 */
class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'corporation_id'  => $this->corporation_id,
            'parent_group_id' => $this->parent_group_id
        ];
    }
}
