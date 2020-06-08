<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ApiException;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Logics\Api\AuthenticationLogic;

/**
 * Class AuthenticationController
 *
 * @package App\Http\Controllers\Api
 */
class AuthenticationController extends BaseController
{
    /**
     * @var AuthenticationLogic|null
     */
    public ?AuthenticationLogic $authenticationLogic = null;

    /**
     * AuthenticationController constructor.
     *
     * @param AuthenticationLogic $authenticationLogic
     */
    public function __construct(AuthenticationLogic $authenticationLogic)
    {
        $this->authenticationLogic = $authenticationLogic;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $this->service = $request->attributes->get('service');

        // check authentication
        $credentials   = [
            'username' => $request->login_id,
            'password' => $request->password
        ];
        $this->account = $this->authenticationLogic->getAuth($credentials);
        if ( ! $this->account) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED);
        }

        // check corporation service contract
        $checkContract = $this->authenticationLogic->checkContract($this->account->corporation_id, $this->service->id);
        if ( ! $checkContract) {
            throw new ApiException(Response::HTTP_FORBIDDEN);
        }

        // save login
        $token        = $this->authenticationLogic->saveLogin($this->account->account_id, $this->service->id);
        $responseData = [
            'access_token' => $token->token,
            'token_type'   => 'bearer',
            'expires_in'   => $token->expires_in->timestamp,
        ];

        return $this->responseApi($responseData);
    }

    /**
     * refresh access token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request)
    {
        $this->service = $request->attributes->get('service');
        $this->account = $request->attributes->get('account');

        // check corporation service contract
        $checkContract = $this->authenticationLogic->checkContract($this->account->corporation_id, $this->service->id);
        if ( ! $checkContract) {
            throw new ApiException(Response::HTTP_FORBIDDEN);
        }

        $token        = $this->authenticationLogic->saveLogin($this->account->account_id, $this->service->id);
        $responseData = [
            'access_token' => $token->token,
            'token_type'   => 'bearer',
            'expires_in'   => $token->expires_in->timestamp,
        ];

        return $this->responseApi($responseData);
    }

    /**
     * logout | remove access token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $this->service = $request->attributes->get('service');
        $this->account = $request->attributes->get('account');

        $this->authenticationLogic->logout($this->account->account_id, $this->service->id);
        return $this->responseApi();
    }
}
