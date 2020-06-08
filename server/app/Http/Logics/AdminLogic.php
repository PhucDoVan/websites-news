<?php

namespace App\Http\Logics;

use App\Http\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use DB;

class AdminLogic
{
    /**
     * Get list manager
     *
     * @param $keyword
     * @param string $sortColumn
     * @param string $sortDirection
     * @param int $limit
     * @return mixed
     */
    public function getList($keyword, $sortColumn = 'manager_id', $sortDirection = 'asc', $limit = PER_PAGE)
    {
        $result = Manager::where(
            function ($query) use ($keyword) {
                $query->where('managers.name', 'like', '%' . $keyword . '%')
                    ->orWhere('managers.username', 'like', '%' . $keyword . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->select('managers.*')
            ->paginate($limit);
        return $result;
    }

    /**
     * Destroy an manager
     *
     * @param $managerId
     * @return bool
     */
    public function destroy($managerId)
    {
        try {
            DB::beginTransaction();

            Manager::destroy($managerId);

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ManagerLogic.destroy', $exception->getTrace());
            return false;
        }
    }

    /**
     * Store an manager
     *
     * @param $parameters
     * @return mixed
     * @throws \Exception
     */
    public function store($parameters)
    {
        try {
            DB::beginTransaction();

            $manager           = new Manager($parameters->all([
                'name',
                'username',
            ]));
            $manager->password = Hash::make($parameters['password']);
            $manager->save();

            DB::commit();
            return $manager;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ManagerLogic.store', $exception->getTrace());
            return false;
        }
    }

    /**
     * Update an manager
     *
     * @param $managerId
     * @param $parameters
     * @return mixed
     */
    public function update($managerId, $parameters)
    {
        try {
            DB::beginTransaction();

            $manager           = Manager::find($managerId);
            $manager->name     = $parameters->get('name');
            $manager->username = $parameters->get('username');
            if ( ! empty($parameters->get('password', ''))) {
                $manager->password = Hash::make($parameters->get('password'));
            }
            $manager->save();

            DB::commit();
            return $manager;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('ManagerLogic.update', $exception->getTrace());
            return false;
        }
    }
}
