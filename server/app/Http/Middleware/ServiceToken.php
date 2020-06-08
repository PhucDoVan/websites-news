<?php

namespace App\Http\Middleware;

use App\Enums\Required;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ApiException;
use App\Http\Logics\Api\AuthenticationLogic;

class ServiceToken
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
     * @param string $isRequired
     * @return mixed
     */
    public function handle($request, Closure $next, $isRequired = Required::YES)
    {
        $isRequired = filter_var($isRequired, FILTER_VALIDATE_BOOLEAN);

        // check missing service token header
        if (empty($request->header('x-service-token'))) {
            if ($isRequired) {
                throw new ApiException(Response::HTTP_NOT_FOUND);
            }
            return $next($request);
        }

        $serviceToken = $request->header('x-service-token');

        // check service token exists
        $service = $this->authenticationLogic->getServiceByToken($serviceToken);

        if (empty($service)) {
            if ($isRequired) {
                throw new ApiException(Response::HTTP_NOT_FOUND);
            }
            return $next($request);
        }

        // push service object to request attributes for using in controller
        $request->attributes->add(['service' => $service]);

        return $next($request);
    }
}
