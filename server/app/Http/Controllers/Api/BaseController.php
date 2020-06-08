<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Models\Service;
use App\Http\Models\Account;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers\Api
 */
class BaseController extends Controller
{
    /**
     * @var Service|null
     */
    public ?Service $service = null;

    /**
     * @var Account|null
     */
    public ?Account $account = null;

    /**
     * Response api data
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function responseApi(
        array $data = [],
        int $status = Response::HTTP_OK,
        array $headers = [],
        int $options = 0
    ) {
        return response()->json($data, $status, $headers, $options);
    }
}
