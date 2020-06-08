<?php

namespace App\Http\Middleware;

use App\Enums\Required;
use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkageCode
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $isRequired
     * @return mixed
     */
    public function handle($request, Closure $next, $isRequired = Required::NO)
    {
        $isRequired = filter_var($isRequired, FILTER_VALIDATE_BOOLEAN);

        $linkageCode        = $request->header('x-linkage-code');
        $isValidLinkageCode = ($linkageCode === config('api.linkage_code'));

        if ($isRequired && ! $isValidLinkageCode) {
            throw new ApiException(Response::HTTP_UNAUTHORIZED);
        }

        if ($isValidLinkageCode) {
            $request->attributes->add(['linkage_code' => $linkageCode]);
        }

        return $next($request);
    }
}
