<?php

namespace App\Http\Traits;

use App\Exceptions\ApiException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ApiExceptionHandlerTrait
{

    /**
     * Creates a new JSON response by status.
     *
     * @param int $status
     * @return JsonResponse
     */
    private function createErrorResponseByStatus(int $status)
    {
        return response()->json([
            'status_code' => $status,
            'error'       => trans('api.' . $status)
        ], $status);
    }

    /**
     * Render new JSON response based on exception type.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response|JsonResponse
     */
    protected function renderJsonResponseForException(Request $request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $exception->getResponse();
        }
        if ($exception instanceof ApiException) {
            return $this->createErrorResponseByStatus($exception->getStatusCode());
        }
        if ($exception instanceof HttpException) {
            switch ($exception->getStatusCode()) {
                case 408: // Timeout
                    return $this->createErrorResponseByStatus(504);
                case 429: // Many Requests
                    return $this->createErrorResponseByStatus(502);
                case 503: // Maintenance
                    return $this->createErrorResponseByStatus(501);
                default:
                    break;

            }
        }
        // If accessed to non-existent API
        if ($exception instanceof NotFoundHttpException) {
            return $this->createErrorResponseByStatus(Response::HTTP_NOT_FOUND);
        }
        return $this->createErrorResponseByStatus(503);
    }

}
