<?php

namespace Tests\Unit\Middleware;

use App\Enums\Required;
use App\Exceptions\ApiException;
use App\Http\Middleware\LinkageCode;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\BaseTest;

/**
 * Class LinkageCodeTest
 *
 * @package App\Http\Middleware\LinkageCode
 * @group middleware
 */
class LinkageCodeTest extends BaseTest
{
    public function testRequiredLinkageCode()
    {
        $request    = Request::create('/api/v1/test', 'GET');
        $middleware = new LinkageCode;

        try {
            // parameters type is string, cause middleware using in route
            $middleware->handle($request, function () {
            }, Required::YES);
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_UNAUTHORIZED),
            $e
        );
    }

    public function testLinkageCodeNG()
    {
        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('X-LINKAGE-CODE', 'linkage code fail');
        $middleware = new LinkageCode;

        try {
            $middleware->handle($request, function () {
            }, Required::YES);
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_UNAUTHORIZED),
            $e
        );
    }

    public function testLinkageCodeOK()
    {
        $requestLinkageCode = 'xxxx-xxxx-yyyy-yyyy-zzzz-zzzz';

        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('X-LINKAGE-CODE', $requestLinkageCode);
        $middleware = new LinkageCode;

        $response   = $middleware->handle($request, function () {
        }, Required::YES);

        $this->assertEquals($request->attributes->get('linkage_code'), $requestLinkageCode);
        $this->assertNull($response);
    }

    public function testLinkageCodeOKByNotRequired()
    {
        $request    = Request::create('/api/v1/test', 'GET');
        $middleware = new LinkageCode;

        $response   = $middleware->handle($request, function () {
        }, Required::NO);

        $this->assertNull($request->attributes->get('linkage_code'));
        $this->assertNull($response);
    }
}
