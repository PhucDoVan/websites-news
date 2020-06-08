<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait ApiTrait
{
    /**
     * Determines if request is an api request. If the request URI contains '/api/'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiRequest(Request $request)
    {
        return strpos($request->getUri(), '/api/') !== false;
    }
}
