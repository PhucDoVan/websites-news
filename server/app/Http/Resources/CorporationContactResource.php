<?php

namespace App\Http\Resources;

use App\Http\Models\CorporationContact;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * Class CorporationContactResource
 *
 * @package App\Http\Resources
 * @mixin CorporationContact
 */
class CorporationContactResource extends JsonResource
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
            'id'             => $this->corporation_contact_id,
            'corporation_id' => $this->corporation_id,
            'name'           => $this->name,
            'tel'            => $this->tel,
            'email'          => $this->email,
            'fax'            => $this->fax
        ];
    }
}
