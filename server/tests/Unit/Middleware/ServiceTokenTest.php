<?php

namespace Tests\Unit\Middleware;

use App\Enums\Required;
use App\Exceptions\ApiException;
use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Middleware\ServiceToken;
use App\Http\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\BaseTest;

/**
 * Class ServiceTokenTest
 *
 * @package Tests\Unit\Middleware\ServiceTokenTest
 * @group middleware
 */
class ServiceTokenTest extends BaseTest
{
    public function testRequiredServiceToken()
    {
        $request    = Request::create('/api/v1/test', 'GET');
        $middleware = new ServiceToken(new AuthenticationLogic);

        try {
            $middleware->handle(
                $request,
                function () {},
                Required::YES
            );
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_NOT_FOUND),
            $e
        );
    }

    public function testServiceTokenNG()
    {
        factory(Service::class)->create([
            'token' => 'service-token-valid'
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('X-SERVICE-TOKEN', 'service-token-fail');
        $middleware = new ServiceToken(new AuthenticationLogic);

        try {
            $middleware->handle(
                $request,
                function () {},
                Required::YES
            );
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_NOT_FOUND),
            $e
        );
    }

    public function testServiceTokenOK()
    {
        $service = factory(Service::class)->create([
            'token' => 'service-token-valid'
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('X-SERVICE-TOKEN', 'service-token-valid');
        $middleware = new ServiceToken(new AuthenticationLogic);

        $response = $middleware->handle(
            $request,
            function () {},
            Required::YES
        );

        $this->assertEquals($request->attributes->get('service')->toArray(), $service->toArray());
        $this->assertNull($response);
    }

    public function testServiceTokenOKByNotRequired()
    {
        factory(Service::class)->create([
            'token' => 'service-token-valid'
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('X-SERVICE-TOKEN', 'service-token-fail');
        $middleware = new ServiceToken(new AuthenticationLogic);

        $response = $middleware->handle(
            $request,
            function () {},
            Required::NO
        );

        $this->assertNull($response);
    }
}
