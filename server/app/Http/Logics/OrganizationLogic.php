<?php

namespace App\Http\Logics;

use App\Enums\CorporationServiceStatus;
use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\CorporationContact;
use App\Http\Models\CorporationService;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;

/**
 * Class OrganizationLogic
 *
 * @package App\Http\Logics
 */
class OrganizationLogic
{
    /**
     * Store organization into DB
     *
     * @param $parameters
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function store($parameters)
    {
        try {
            DB::beginTransaction();

            $parameters['postal'] = str_replace('-', '', $parameters['postal']);

            $corporation = new Corporation($parameters);
            $corporation->save();

            foreach ($parameters['contact_name'] as $index => $value) {
                $contractParams = [
                    'name'  => $value,
                    'tel'   => $parameters['contact_tel'][$index],
                    'email' => $parameters['contact_email'][$index],
                    'fax'   => $parameters['contact_fax'][$index],
                ];

                if (array_filter($contractParams)) {
                    $contact = new CorporationContact($contractParams);
                    $corporation->contacts()->save($contact);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('OrganizationLogic.store', $exception->getTrace());
            return false;
        }
    }

    /**
     * Get organization list
     *
     * @param $keyword
     * @param string $sortColumn
     * @param string $sortDirection
     * @param int $limit
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function getList($keyword, $sortColumn = 'corporation_id', $sortDirection = 'asc', $limit = PER_PAGE)
    {
        $result = Corporation::where(function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('kana', 'like', '%' . $keyword . '%')
                ->orWhere('postal', 'like', '%' . $keyword . '%')
                ->orWhere('address_pref', 'like', '%' . $keyword . '%')
                ->orWhere('address_city', 'like', '%' . $keyword . '%')
                ->orWhere('address_town', 'like', '%' . $keyword . '%')
                ->orWhere('address_etc', 'like', '%' . $keyword . '%');
        })
            ->with('contacts')
            ->whereHas('contacts', function ($query) use ($keyword) {
                $query->orWhere('tel', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('fax', 'like', '%' . $keyword . '%');
            });
        if ($sortColumn === 'name') {
            $result = $result->orderBy('name', $sortDirection)
                ->orderBy('kana', $sortDirection);
        } elseif ($sortColumn === 'address') {
            $result = $result->orderBy('postal', $sortDirection)
                ->orderBy('address_pref', $sortDirection)
                ->orderBy('address_city', $sortDirection)
                ->orderBy('address_town', $sortDirection)
                ->orderBy('address_etc', $sortDirection);
        } elseif ($sortColumn === 'contact') {
            $result = $result->orderBy('tel', $sortDirection)
                ->orderBy('fax', $sortDirection)
                ->orderBy('email', $sortDirection);
        } else {
            $result = $result->orderBy($sortColumn, $sortDirection);
        }
        $result = $result->paginate($limit);
        return $result;
    }

    /**
     * get list organizations duplicate with current entity
     *
     * @param $organization
     * @return mixed
     */
    public function getDuplicateByEntity($organization)
    {
        $organizations = Corporation::where('corporation_id', '<>', $organization->corporation_id)
            ->where(function ($query) use ($organization) {
                $query->where('name', 'like', '%' . $organization->name . '%');
                $query->orWhereRaw("'" . $organization->name . "' like concat('%', name ,'%')");

                if ($organization->kana) {
                    $query->orWhere('kana', 'like', '%' . $organization->kana . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('kana');
                        $query->where('kana', '<>', '');
                        $query->whereRaw("'" . $organization->kana . "' like concat('%', `kana` ,'%')");
                    });
                }
                if ($organization->postal_code) {
                    $query->orWhere('postal_code', 'like', '%' . $organization->postal_code . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('postal_code');
                        $query->where('postal_code', '<>', '');
                        $query->whereRaw("'" . $organization->postal_code . "' like concat('%', `postal_code` ,'%')");
                    });
                }
                if ($organization->address_pref) {
                    $query->orWhere('address_pref', 'like', '%' . $organization->address_pref . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('address_pref');
                        $query->where('address_pref', '<>', '');
                        $query->whereRaw("'" . $organization->address_pref . "' like concat('%', `address_pref` ,'%')");
                    });
                }
                if ($organization->address_city) {
                    $query->orWhere('address_city', 'like', '%' . $organization->address_city . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('address_city');
                        $query->where('address_city', '<>', '');
                        $query->whereRaw("'" . $organization->address_city . "' like concat('%', `address_city` ,'%')");
                    });
                }
                if ($organization->address_town) {
                    $query->orWhere('address_town', 'like', '%' . $organization->address_town . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('address_town');
                        $query->where('address_town', '<>', '');
                        $query->whereRaw("'" . $organization->address_town . "' like concat('%', `address_town` ,'%')");
                    });
                }
                if ($organization->address_building) {
                    $query->orWhere('address_building', 'like', '%' . $organization->address_building . '%');
                    $query->orWhere(function ($query) use ($organization) {
                        $query->whereNotNull('address_building');
                        $query->where('address_building', '<>', '');
                        $query->whereRaw("'" . $organization->address_building . "' like concat('%', `address_building` ,'%')");
                    });
                }
                if ($organization->tel) {
                    $query->orWhere('tel', 'like', '%' . $organization->tel . '%');
                }
                if ($organization->email) {
                    $query->orWhere('email', 'like', '%' . $organization->email . '%');
                }
                if ($organization->fax) {
                    $query->orWhere('fax', 'like', '%' . $organization->fax . '%');
                }
            })
            ->get();

        return $organizations;
    }

    /**
     * get list organizations duplicate by keyword
     *
     * @param $corporationId
     * @param $keyword
     * @return mixed
     */
    public function getDuplicateByKeyword($corporationId, $keyword)
    {
        $organizations = Corporation::where('corporation_id', '<>', $corporationId)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->orWhere('kana', 'like', '%' . $keyword . '%');
                $query->orWhere('postal_code', 'like', '%' . $keyword . '%');
                $query->orWhere('address_pref', 'like', '%' . $keyword . '%');
                $query->orWhere('address_city', 'like', '%' . $keyword . '%');
                $query->orWhere('address_town', 'like', '%' . $keyword . '%');
                $query->orWhere('address_building', 'like', '%' . $keyword . '%');
                $query->orWhere('tel', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
                $query->orWhere('fax', 'like', '%' . $keyword . '%');
            })
            ->get();

        return $organizations;
    }

    /**
     * Merge data's corporation source to target
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
            $corporationSource = Corporation::find($idSource);

            $this->mergeAccounts($corporationSource->accounts, $idTarget);
            $this->mergeContacts($corporationSource->contacts, $idTarget);

            $corporationSource->delete();

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('OrganizationLogic.merge', $exception->getTrace());
            return false;
        }
    }

    /**
     * Merge corporation's account
     *
     * @param $accounts
     * @param $corporationIdTarget
     * @used-by merge()
     */
    private function mergeAccounts($accounts, $corporationIdTarget)
    {
        foreach ($accounts as $account) {
            $newAccount                 = $account->replicate();
            $newAccount->corporation_id = $corporationIdTarget;
            $newAccount->save();

            foreach ($account->services as $service) {
                $newService             = $service->replicate();
                $newService->account_id = $newAccount->account_id;
                $newService->save();
                $service->delete();
            }

            foreach ($account->restricts as $restrict) {
                $newRestrict             = $restrict->replicate();
                $newRestrict->account_id = $newAccount->account_id;
                $newRestrict->save();
                $restrict->delete();
            }

            $newPurchaseHistoryId = PurchaseHistory::max('purchase_history_id') + 1;
            foreach ($account->purchaseHistories as $purchase) {
                $newPurchase = new PurchaseHistory();
                $newPurchase->fill([
                    'purchase_history_id' => $newPurchaseHistoryId,
                    'account_id'          => $newAccount->account_id,
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
            $account->delete();
        }
    }

    /**
     * Merge corporation's contact
     *
     * @param $contacts
     * @param $corporationIdTarget
     * @used-by merge()
     */
    private function mergeContacts($contacts, $corporationIdTarget)
    {
        foreach ($contacts as $contact) {
            $newContact                 = $contact->replicate();
            $newContact->corporation_id = $corporationIdTarget;
            $newContact->save();

            $contact->delete();
        }
    }

    /**
     * Delete for organization
     *
     * @param $corporationId
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function deleteOrganization($corporationId)
    {
        try {
            DB::beginTransaction();

            Corporation::destroy($corporationId);

            $accounts = Account::where('corporation_id', $corporationId)->get();
            foreach ($accounts as $account) {
                $account->delete();
                $account->restricts()->delete();
            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('OrganizationLogic.delete', $exception->getTrace());
            return false;
        }
    }

    /**
     * Update for organization
     *
     * @param $parameters
     * @param $corporationId
     * @return bool
     * @author nvmanh.sgt@gmail.com
     */
    public function updateOrganization($parameters, $corporationId)
    {
        try {
            DB::beginTransaction();

            $parameters['postal'] = str_replace('-', '', $parameters['postal']);

            $corporation = Corporation::find($corporationId);
            $corporation->fill($parameters);
            $corporation->save();
            $corporation->contacts()->delete();

            foreach ($parameters['contact_name'] as $index => $value) {
                $contractParams = [
                    'name'  => $value,
                    'tel'   => $parameters['contact_tel'][$index],
                    'email' => $parameters['contact_email'][$index],
                    'fax'   => $parameters['contact_fax'][$index],
                ];

                if (array_filter($contractParams)) {
                    $contact = new CorporationContact($contractParams);
                    $corporation->contacts()->save($contact);
                }
            }

            DB::commit();

            return $corporation;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('OrganizationLogic.update', $exception->getTrace());
            return false;
        }
    }

    /**
     * Update corporation service status
     *
     * @param $corporationId
     * @param $serviceId
     * @param $status
     * @return bool
     */
    public function updateServiceStatus($corporationId, $serviceId, $status)
    {
        $corporationService = CorporationService::findByCorporationID($corporationId, $serviceId);

        if ($status === CorporationServiceStatus::TERMINATED) {
            $corporationService->terminated_at = Carbon::now();
        } else {
            $corporationService->status = $status;
        }

        return $corporationService->save();
    }
}
