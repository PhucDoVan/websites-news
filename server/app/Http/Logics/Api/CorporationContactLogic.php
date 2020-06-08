<?php


namespace App\Http\Logics\Api;

use App\Http\Models\CorporationContact;

class CorporationContactLogic
{
    /**
     * Create a contact of corporation
     *
     * @param $parameters
     * @return CorporationContact
     */
    public function store($parameters)
    {
        $corporationContact = new CorporationContact($parameters);
        $corporationContact->save();

        return $corporationContact;
    }
}
