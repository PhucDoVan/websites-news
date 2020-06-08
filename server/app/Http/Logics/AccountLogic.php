<?php

namespace App\Http\Logics;

use App\Http\Models\Account;
use App\Http\Models\ServiceRestrict;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccountLogic
{
    /**
     * Get list account
     *
     * @param $keyword
     * @param string $sortColumn
     * @param string $sortDirection
     * @param int $limit
     * @return mixed
     */
    public function getList($keyword, $sortColumn = 'account_id', $sortDirection = 'asc', $limit = PER_PAGE)
    {
        $result = Account::leftJoin('corporations as co', 'co.corporation_id', '=', 'accounts.corporation_id')
            ->whereNull('co.deleted_at')
            ->where(function ($query) use ($keyword) {
                $query->where('accounts.username', 'like', '%' . $keyword . '%')
                    ->orWhere('accounts.name_last', 'like', '%' . $keyword . '%')
                    ->orWhere('accounts.name_first', 'like', '%' . $keyword . '%')
                    ->orWhere('accounts.kana_last', 'like', '%' . $keyword . '%')
                    ->orWhere('accounts.kana_first', 'like', '%' . $keyword . '%')
                    ->orWhere('co.name', 'like', '%' . $keyword . '%');
            });
        if ($sortColumn === 'name') {
            $result = $result->orderBy('accounts.name_last', $sortDirection)
                ->orderBy('accounts.name_first', $sortDirection);
        } elseif ($sortColumn === 'kana') {
            $result = $result->orderBy('accounts.kana_last', $sortDirection)
                ->orderBy('accounts.kana_first', $sortDirection);
        } else {
            $result = $result->orderBy($sortColumn, $sortDirection);
        }
        $result = $result->select('accounts.*')
            ->paginate($limit);
        return $result;
    }

    /**
     * get account info join with corporation related by account id
     *
     * @param $accountId
     * @return mixed
     */
    public function getAccountWithCorporation($accountId)
    {
        $account = Account::select('accounts.*', 'co.name as corporation_name')
            ->leftJoin('corporations as co', 'co.corporation_id', '=', 'accounts.corporation_id')
            ->find($accountId);

        return $account;
    }

    /**
     * get list accounts duplicate with current entity
     *
     * @param $account
     * @return mixed
     */
    public function getDuplicateByEntity($account)
    {
        $accounts = Account::select('accounts.*', 'co.name as corporation_name')
            ->leftJoin('corporations as co', 'co.corporation_id', '=', 'accounts.corporation_id')
            ->where('account_id', '<>', $account->account_id)
            ->where(function ($query) use ($account) {
                $query->where('name_last', 'like', '%' . $account->name_last . '%');
                $query->orWhere('name_first', 'like', '%' . $account->name_first . '%');
                $query->orWhere('kana_last', 'like', '%' . $account->kana_last . '%');
                $query->orWhere('kana_first', 'like', '%' . $account->kana_first . '%');
                $query->orWhereRaw("'" . $account->name_last . "' like concat('%', `accounts`.`name_last` ,'%')");
                $query->orWhereRaw("'" . $account->name_first . "' like concat('%', `accounts`.`name_first` ,'%')");
                $query->orWhereRaw("'" . $account->kana_last . "' like concat('%', `accounts`.`kana_last` ,'%')");
                $query->orWhereRaw("'" . $account->kana_first . "' like concat('%', `accounts`.`kana_first` ,'%')");
            })
            ->get();

        return $accounts;
    }

    /**
     * get list accounts duplicate by keyword
     *
     * @param $accountId
     * @param $keyword
     * @return mixed
     */
    public function getDuplicateByKeyword($accountId, $keyword)
    {
        $accounts = Account::select('accounts.*', 'co.name as corporation_name')
            ->leftJoin('corporations as co', 'co.corporation_id', '=', 'accounts.corporation_id')
            ->where('account_id', '<>', $accountId)
            ->where(function ($query) use ($keyword) {
                $query->orWhere('kana_first', 'like', '%' . $keyword . '%');
                $query->orWhere('kana_last', 'like', '%' . $keyword . '%');
                $query->orWhere('name_first', 'like', '%' . $keyword . '%');
                $query->orwhere('name_last', 'like', '%' . $keyword . '%');
            })
            ->get();

        return $accounts;
    }

    /**
     * Merge data's account source to target
     * - Copy relations data source to target
     * - Delete data source
     *
     * @param $idTarget
     * @param $idSource
     * @return bool
     */
    public function merge($idTarget, $idSource)
    {
        try {
            DB::beginTransaction();
            $accountSource = Account::find($idSource);

            foreach ($accountSource->services as $service) {
                $newService             = $service->replicate();
                $newService->account_id = $idTarget;
                $newService->save();
                $service->delete();
            }

            foreach ($accountSource->restricts as $restrict) {
                $newRestrict             = $restrict->replicate();
                $newRestrict->account_id = $idTarget;
                $newRestrict->save();
                $restrict->delete();
            }

            $newPurchaseHistoryId = PurchaseHistory::max('purchase_history_id') + 1;
            foreach ($accountSource->purchaseHistories as $purchase) {
                $newPurchase = new PurchaseHistory();
                $newPurchase->fill([
                    'purchase_history_id' => $newPurchaseHistoryId,
                    'account_id'          => $idTarget,
                    'service_id'          => $purchase->service_id,
                    'content_id'          => $purchase->content_id
                ]);

                // Eloquent's not support composite primary keys
                PurchaseHistory::where([
                    'purchase_history_id' => $purchase->purchase_history_id,
                    'service_id'          => $purchase->service_id,
                    'content_id'          => $purchase->content_id
                ])->delete();

                $newPurchase->save();
            }
            $accountSource->delete();

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('OrganizationLogic.merge', $exception->getTrace());
            return false;
        }
    }

    /**
     * Destroy an account
     *
     * @param $accountId
     * @return bool
     */
    public function destroy($accountId)
    {
        try {
            DB::beginTransaction();

            $account = Account::find($accountId);
            $account->delete();
            $account->restricts()->delete();

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('AccountLogic.destroyAccount', $exception->getTrace());
            return false;
        }
    }

    /**
     * Store an account
     *
     * @param $parameters
     * @return mixed
     * @throws \Exception
     */
    public function store($parameters)
    {
        try {
            DB::beginTransaction();

            // mockup - get first group of corporation
            $account           = new Account($parameters);
            $group             = $account->corporation->groups()->first();
            $account->group_id = $group->id;
            $account->password = Hash::make($parameters['password']);
            $account->save();

            foreach ($parameters['restrict_ips'] ?? [] as $restrictIp) {
                if (empty($restrictIp)) {
                    continue;
                }
                $account->restricts()->save(new ServiceRestrict([
                    'type'  => RESTRICT_TYPE_IP,
                    'value' => $restrictIp
                ]));
            }

            DB::commit();
            return $account;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('AccountLogic.store', $exception->getTrace());
            return false;
        }
    }

    /**
     * Update an account
     *
     * @param $accountId
     * @param $parameters
     * @return mixed
     */
    public function update($accountId, $parameters)
    {
        try {
            DB::beginTransaction();

            if ( ! empty($parameters['password'] ?? '')) {
                $parameters['password'] = Hash::make($parameters['password']);
            } else {
                unset($parameters['password']);
            }
            $account = Account::find($accountId);
            $account->fill($parameters);
            $account->save();
            $account->restricts()->delete();
            foreach ($parameters['restrict_ips'] ?? [] as $restrictIp) {
                if (empty($restrictIp)) {
                    continue;
                }
                $account->restricts()->save(new ServiceRestrict([
                    'type'  => RESTRICT_TYPE_IP,
                    'value' => $restrictIp
                ]));
            }

            DB::commit();
            return $account;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('AccountLogic.update', $exception->getTrace());
            return false;
        }
    }
}
