<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ApiException;
use App\Enums\UriParameterType;
use App\Http\Logics\Api\AuthenticationLogic;

class AccessToken
{
    private ?AuthenticationLogic $authenticationLogic = null;

    public function __construct(AuthenticationLogic $authenticationLogic)
    {
        $this->authenticationLogic = $authenticationLogic;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $uriParamType
     * @return mixed
     */
    public function handle($request, Closure $next, $uriParamType = '')
    {
        // if previous middleware check linkage_code is passed, no need to check authorization
        if ($request->attributes->get('linkage_code')) {
            return $next($request);
        }

        // check missing access token header
        if (empty($request->header('authorization'))) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = str_replace('Bearer ', '', $request->header('authorization'));
        $service     = $request->attributes->get('service');

        $tokenObject = $this->authenticationLogic->getAccessToken($accessToken, $service);
        if (empty($tokenObject)) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED);
        }

        $account = $tokenObject->account;
        switch ($uriParamType) {
            case UriParameterType::CORPORATION:
                if ($account->corporation_id != $request->corporation_id) {
                    throw new ApiException(Response::HTTP_NOT_FOUND);
                }
                break;
            case UriParameterType::GROUP:
                if ($account->group_id != $request->group_id) {
                    throw new ApiException(Response::HTTP_NOT_FOUND);
                }
                break;
        }

        // push account object to request attributes for using in controller
        $request->attributes->add(['account' => $account]);

        return $next($request);
    }
}
