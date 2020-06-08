<?php

namespace App\Http\Resources;

use App\Http\Models\Corporation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CorporationInformationResource
 *
 * @package App\Http\Resources
 * @mixin Corporation
 */
class CorporationInformationResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        self::withoutWrapping();
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->corporation_id,
            'name'         => $this->name,
            'kana'         => $this->kana,
            'uid'          => $this->uid,
            'postal'       => $this->postal,
            'address_pref' => $this->address_pref,
            'address_city' => $this->address_city,
            'address_town' => $this->address_town,
            'address_etc'  => $this->address_etc,
            'contacts'     => CorporationContactResource::collection($this->contacts)
        ];
    }
}
