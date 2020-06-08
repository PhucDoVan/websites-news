<?php

namespace App\Http\Logics;

use App\Http\Models\Service;
use DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ServiceLogic
 *
 * @package App\Http\Logics
 */
class ServiceLogic
{
    /**
     * Store service into DB
     *
     * @param $parameters
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function store($parameters)
    {
        try {
            DB::beginTransaction();
            $service = new Service();

            $service->name = $parameters['name'];

            $service->save();
            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ServiceLogic.store', $exception->getTrace());
            return false;
        }
    }

    /**
     * Get service list
     *
     * @param $keyword
     * @param string $sortColumn
     * @param string $sortDirection
     * @param int $limit
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function getList($keyword, $sortColumn = 'id', $sortDirection = 'asc', $limit = PER_PAGE)
    {
        $result = Service::whereNull('deleted_at')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate($limit);
        return $result;
    }

    /**
     * Delete for service
     *
     * @param $serviceId
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function deleteService($serviceId)
    {
        try {
            DB::beginTransaction();

            Service::destroy($serviceId);

            ServiceAccount::where('id', $serviceId)->delete();

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ServiceLogic.delete', $exception->getTrace());
            return false;
        }
    }

    /**
     * Update for service
     *
     * @param $parameters
     * @param $serviceId
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function updateService($parameters, $serviceId)
    {
        try {
            DB::beginTransaction();

            $service       = Service::find($serviceId);
            $service->name = $parameters['name'];
            $service->save();

            DB::commit();

            return $service;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ServiceLogic.update', $exception->getTrace());
            return false;
        }
    }
}
