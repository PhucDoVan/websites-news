<?php


namespace App\Http\Controllers\Api;

use App\Enums\CorporationServiceStatus;
use App\Enums\Service;
use App\Http\Logics\Api\AccountLogic;
use App\Http\Logics\Api\CorporationContactLogic;
use App\Http\Logics\Api\CorporationLogic;
use App\Http\Logics\Api\CorporationServiceLogic;
use App\Http\Logics\Api\GroupLogic;
use App\Http\Logics\Api\RoleLogic;
use App\Http\Models\Role;
use App\Http\Requests\Api\ServiceApplicationRequest;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helpers\GenerateHelper;

class ServiceApplicationController extends BaseController
{
    public CorporationLogic        $corporationLogic;
    public CorporationContactLogic $corporationContactLogic;
    public CorporationServiceLogic $corporationServiceLogic;
    public GroupLogic              $groupLogic;
    public AccountLogic            $accountLogic;

    /**
     * ServiceApplicationController constructor.
     *
     * @param CorporationLogic $corporationLogic
     * @param CorporationContactLogic $corporationContactLogic
     * @param CorporationServiceLogic $corporationServiceLogic
     * @param GroupLogic $groupLogic
     * @param AccountLogic $accountLogic
     */
    public function __construct(
        CorporationLogic $corporationLogic,
        CorporationContactLogic $corporationContactLogic,
        CorporationServiceLogic $corporationServiceLogic,
        GroupLogic $groupLogic,
        AccountLogic $accountLogic
    ) {
        $this->corporationLogic        = $corporationLogic;
        $this->corporationContactLogic = $corporationContactLogic;
        $this->corporationServiceLogic = $corporationServiceLogic;
        $this->groupLogic              = $groupLogic;
        $this->accountLogic            = $accountLogic;
    }

    /**
     * @param ServiceApplicationRequest $request
     * @return JsonResponse|null
     */
    public function register(ServiceApplicationRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->service = $request->attributes->get('service');
            $uid           = $this->corporationLogic->generateUID(3);
            if ( ! $uid) {
                throw new ApiException(Response::HTTP_SERVICE_UNAVAILABLE);
            }

            $username = $this->accountLogic->generateUsername($uid, 3);
            if ( ! $username) {
                throw new ApiException(Response::HTTP_SERVICE_UNAVAILABLE);
            }

            $password        = GenerateHelper::generatePassword(10);
            $roleNameDefault = RoleLogic::getRoleNameDefaultByService(Service::SHIKAKU_ID);
            $role            = Role::findByName($roleNameDefault);

            //  Create corporation
            $corporationParams = array_merge($request->corporation);
            $corporationNew    = $this->corporationLogic->store($corporationParams);

            //  Create contact of corporation
            $contactParams = array_merge($request->corporation, [
                'corporation_id' => $corporationNew->corporation_id
            ]);
            $contactNew    = $this->corporationContactLogic->store($contactParams);

            //  Create service of corporation
            $corporationService = array_merge($request->contract, [
                'corporation_id' => $corporationNew->corporation_id,
                'service_id'     => optional($this->service)->id,
                'status'         => CorporationServiceStatus::ACTIVE,
            ]);
            $this->corporationServiceLogic->store($corporationService);

            //  Create department of corporation
            $group         = [
                'corporation_id' => $corporationNew->corporation_id,
                'name'           => GroupLogic::GROUP_NAME_DEFAULT,
            ];
            $departmentNew = $this->groupLogic->store($group);

            //  Create account
            $accountParams = array_merge($request->account, [
                'corporation_id' => $corporationNew->corporation_id,
                'group_id'       => $departmentNew->id,
                'username'       => $username,
                'password'       => $password,
                'uid'            => $corporationNew->uid,
                'role_id'        => $role->id
            ]);
            $accountNew    = $this->accountLogic->store($accountParams);
            $responseData  = $this->reformatResponseApi($corporationNew, $contactNew, $accountNew, $password);

            DB::commit();
            return $this->responseApi($responseData);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ApiException(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Reformat response api
     *
     * @param $corporationNew
     * @param $contactNew
     * @param $accountNew
     * @param $passwordAccount
     * @return array
     */
    private function reformatResponseApi($corporationNew, $contactNew, $accountNew, $passwordAccount)
    {
        return [
            'id'           => $corporationNew->corporation_id,
            'name'         => $corporationNew->name,
            'kana'         => $corporationNew->kana,
            'uid'          => $corporationNew->uid,
            'postal'       => $corporationNew->postal,
            'address_pref' => $corporationNew->address_pref,
            'address_city' => $corporationNew->address_city,
            'address_town' => $corporationNew->address_town,
            'address_etc'  => $corporationNew->address_etc,
            'contact'      => [
                'id'             => $contactNew->corporation_contact_id,
                'corporation_id' => $contactNew->corporation_id,
                'name'           => $contactNew->name,
                'tel'            => $contactNew->tel,
                'email'          => $contactNew->email,
                'fax'            => $contactNew->fax
            ],
            'account'      => [
                'id'         => $accountNew->account_id,
                'name_last'  => $accountNew->name_last,
                'name_first' => $accountNew->name_first,
                'kana_last'  => $accountNew->kana_last,
                'kana_first' => $accountNew->kana_first,
                'username'   => $accountNew->username,
                'password'   => $passwordAccount
            ]
        ];
    }
}
