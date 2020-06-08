<?php

namespace Tests\Feature\Api;

use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Logics\Api\CorporationServiceLogic;
use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TerminateServiceTest
 *
 * @package Tests\Feature\Api
 */
class TerminateServiceTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->httpMethod = 'post';
        $this->uri        = '/api/v1/corporations/1/terminate';
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyServiceTokenNGProvider
     */
    public function testVerifyServiceTokenNG($headers, $expected)
    {
        parent::verifyServiceTokenNG($headers, $expected);
    }

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyAccessTokenNGProvider
     */
    public function testVerifyAccessTokenNG($headers, $expected)
    {
        parent::verifyAccessTokenNG($headers, $expected);
    }

    public function testVerifyUriParamNG()
    {
        parent::verifyUriParamNG();
    }

    public function testCheckPermissionNG()
    {
        parent::checkPermissionNG();
    }

    /**
     * @return array
     */
    public function validateParamNGProvider()
    {
        return [
            [
                // empty
                [],
                [
                    'target'  => 'datetime',
                    'message' => 'datetimeは、必ず指定してください。'
                ]
            ],
            [
                // datetime format wrong
                [
                    'datetime' => '2020/04/30 23:59:59',
                ],
                [
                    'target'  => 'datetime',
                    'message' => "datetimeの形式は、'Y-m-d H:i:s'と合いません。"
                ]
            ],
        ];
    }

    /**
     * @param $requestParams
     * @param $expected
     * @dataProvider validateParamNGProvider
     */
    public function testValidateParamsNG($requestParams, $expected)
    {
        parent::validateParamsNG($requestParams, $expected);
    }

    public function testUpdateCorporationServiceFail()
    {
        // mock check permission OK
        $this->mockPermission(true);

        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock get service token OK
        $serviceMock = new Service([
            'id'    => 1,
            'name'  => 'service testing',
            'token' => 'yyyy-yyyy-yyyy-yyyy',
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock get access token OK
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => $this->uriCorporationId,
            'group_id'       => $this->uriGroupId,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);

        // mock updateExpireByCorporationTerminate return true
        $authenticationLogic
            ->shouldReceive('updateExpireByCorporationTerminate')
            ->andReturn(true);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $corporationServiceLogic = Mockery::mock(CorporationServiceLogic::class);
        $corporationServiceLogic->shouldReceive('terminate')
            ->andThrowExceptions([new \Exception('update DB fail')]);
        $this->app->instance(CorporationServiceLogic::class, $corporationServiceLogic);

        $requestParams = [
            'datetime' => '2020-02-20 20:20:20'
        ];
        $requestHeaders = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi($requestParams, $requestHeaders);
        $responseData = $response->getData();
        $this->assertEquals($response->status(), Response::HTTP_SERVICE_UNAVAILABLE);
        $this->assertEquals($responseData->error, 'サーバー側でエラーが発生');
    }

    public function testTokenExpiresFail()
    {
        // mock check permission OK
        $this->mockPermission(true);

        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock get service token OK
        $serviceMock = new Service([
            'id'    => 1,
            'name'  => 'service testing',
            'token' => 'yyyy-yyyy-yyyy-yyyy',
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock get access token OK
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => $this->uriCorporationId,
            'group_id'       => $this->uriGroupId,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);

        // mock updateExpireByCorporationTerminate return true
        $authenticationLogic
            ->shouldReceive('updateExpireByCorporationTerminate')
            ->andThrowExceptions([new \Exception('update DB fail')]);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $corporationServiceLogic = Mockery::mock(CorporationServiceLogic::class);
        $corporationServiceLogic->shouldReceive('terminate')
            ->andReturn(true);
        $this->app->instance(CorporationServiceLogic::class, $corporationServiceLogic);

        $requestParams = [
            'datetime' => '2020-02-20 20:20:20'
        ];
        $requestHeaders = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi($requestParams, $requestHeaders);
        $responseData = $response->getData();
        $this->assertEquals($response->status(), Response::HTTP_SERVICE_UNAVAILABLE);
        $this->assertEquals($responseData->error, 'サーバー側でエラーが発生');
    }

    public function testTerminateOk()
    {
        // mock check permission OK
        $this->mockPermission(true);

        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock get service token OK
        $serviceMock = new Service([
            'id'    => 1,
            'name'  => 'service testing',
            'token' => 'yyyy-yyyy-yyyy-yyyy',
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock get access token OK
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => $this->uriCorporationId,
            'group_id'       => $this->uriGroupId,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);

        // mock updateExpireByCorporationTerminate return true
        $authenticationLogic
            ->shouldReceive('updateExpireByCorporationTerminate')
            ->andReturn(true);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $corporationServiceLogic = Mockery::mock(CorporationServiceLogic::class);
        $corporationServiceLogic->shouldReceive('terminate')
            ->andReturn(true);
        $this->app->instance(CorporationServiceLogic::class, $corporationServiceLogic);

        $requestParams = [
            'datetime' => '2020-02-20 20:20:20'
        ];
        $requestHeaders = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi($requestParams, $requestHeaders);
        $response->assertStatus(Response::HTTP_OK);
    }
}
