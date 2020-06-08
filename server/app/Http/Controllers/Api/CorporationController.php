<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Logics\Api\CorporationContactLogic;
use App\Http\Logics\Api\CorporationLogic;
use App\Http\Logics\Api\CorporationServiceLogic;
use App\Http\Requests\Api\CorporationInformationRequest;
use App\Http\Requests\Api\TerminateCorporationRequest;
use App\Http\Requests\Api\ServiceContractStatusRequest;
use App\Http\Resources\CorporationInformationResource;
use App\Http\Models\CorporationService;
use App\Http\Models\Corporation;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CorporationController extends BaseController
{
    public CorporationServiceLogic $corporationServiceLogic;
    public AuthenticationLogic     $authenticationLogic;
    public CorporationLogic        $corporationLogic;
    public CorporationContactLogic $contactLogic;

    /**
     * CorporationController constructor.
     *
     * @param CorporationServiceLogic $corporationServiceLogic
     * @param AuthenticationLogic $authenticationLogic
     * @param CorporationLogic $corporationLogic
     * @param CorporationContactLogic $contactLogic
     */
    public function __construct(
        CorporationServiceLogic $corporationServiceLogic,
        AuthenticationLogic $authenticationLogic,
        CorporationLogic $corporationLogic,
        CorporationContactLogic $contactLogic
    ) {
        $this->corporationServiceLogic = $corporationServiceLogic;
        $this->authenticationLogic     = $authenticationLogic;
        $this->corporationLogic        = $corporationLogic;
        $this->contactLogic            = $contactLogic;
    }

    /**
     * Api terminate service
     *
     * @param TerminateCorporationRequest $request
     * @param $corporationId
     * @return JsonResponse
     */
    public function terminate(TerminateCorporationRequest $request, $corporationId)
    {
        try {
            DB::beginTransaction();

            $service = $request->attributes->get('service');

            $this->corporationServiceLogic->terminate($corporationId, $service->id, $request->datetime);
            $this->authenticationLogic->updateExpireByCorporationTerminate(
                $corporationId,
                $request->datetime
            );

            DB::commit();
            return $this->responseApi();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ApiException(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Retrieve service contract status
     *
     * @param $corporationId
     * @param Request $request
     * @return JsonResponse
     */
    public function getServiceContractStatus(Request $request, $corporationId)
    {
        $this->service      = $request->attributes->get('service');
        $serviceId          = optional($this->service)->id;
        $corporationService = CorporationService::findByCorporationID($corporationId, $serviceId);
        if (empty($corporationService)) {
            throw new ApiException(Response::HTTP_NOT_FOUND);
        }
        $responseData = [
            'status' => $corporationService->status
        ];

        return $this->responseApi($responseData);
    }

    /**
     * Change service contract status
     *
     * @param ServiceContractStatusRequest $request
     * @param $corporationId
     * @return JsonResponse
     */
    public function updateServiceContractStatus(ServiceContractStatusRequest $request, $corporationId)
    {
        $this->service = $request->attributes->get('service');
        $serviceId     = $this->service->id;
        $status        = $request->status;

        $serviceContract = CorporationService::findByCorporationID($corporationId, $serviceId);
        if (empty($serviceContract)) {
            throw new ApiException(Response::HTTP_NOT_FOUND);
        }
        $this->corporationServiceLogic->updateStatus($serviceContract, $status);
        DB::commit();
        return $this->responseApi();
    }

    /**
     * Acquisition of corporation information
     *
     * @param $corporationId
     * @return CorporationInformationResource
     */
    public function acquisitionInformation($corporationId)
    {
        $corporation = Corporation::with('contacts')->find($corporationId);
        return new CorporationInformationResource($corporation);
    }

    /**
     * Update of corporation information
     *
     * @param CorporationInformationRequest $request
     * @param $corporationId
     * @return CorporationInformationResource
     */
    public function updateCorporationInformation(CorporationInformationRequest $request, $corporationId)
    {
        try {
            DB::beginTransaction();
            $corporationUpdated = $this->corporationLogic->updateInformation($corporationId, $request->all());
            DB::commit();
            return new CorporationInformationResource($corporationUpdated);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ApiException(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * TODO: test
     * Get the total number of active accounts
     *
     * @param $corporationId
     * @return JsonResponse
     */
    public function activeAccounts($corporationId)
    {
        $count = $this->corporationLogic->countShikakumapActiveAccounts($corporationId);
        return $this->responseApi(['total' => $count]);
    }
}
