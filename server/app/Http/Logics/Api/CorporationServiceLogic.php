<?php

namespace App\Http\Logics\Api;

use App\Http\Models\CorporationService;

class CorporationServiceLogic
{
    /**
     * Create a service of corporation
     *
     * @param $parameters
     * @return CorporationService
     */
    public function store($parameters)
    {
        $corporationService = new CorporationService($parameters);
        $corporationService->save();

        return $corporationService;
    }

    /**
     * Terminate service of corporation
     *
     * @param $corporationId
     * @param $serviceId
     * @param $datetime
     * @return mixed
     */
    public function terminate($corporationId, $serviceId, $datetime)
    {
        return CorporationService::where([
            'corporation_id' => $corporationId,
            'service_id'     => $serviceId,
        ])
            ->update([
                'terminated_at' => $datetime
            ]);
    }

    /**
     * Update service contract status
     *
     * @param $serviceContract
     * @param int $status
     * @return mixed
     */
    public function updateStatus($serviceContract, $status)
    {
        $serviceContract->status = $status;
        return $serviceContract->save();
    }
}
