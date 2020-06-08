<?php

namespace Tests\Feature\Api;

use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RefreshTokenTest
 *
 * @package Tests\Feature\Api
 */
class RefreshTokenTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri = '/api/auth/refresh';
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

    public function testCheckContractNG()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $serviceMock     = new Service([
            'id'    => 1,
            'name'  => 'service testing',
            'token' => 'yyyy-yyyy-yyyy-yyyy',
        ]);
        $serviceMock->id = 1;
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => $this->uriCorporationId,
            'group_id'       => $this->uriGroupId,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);

        // mock AuthenticationLogic->checkContract() return false
        $authenticationLogic->shouldReceive('checkContract')->andReturn(false);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $response = $this->callApi([], [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $responseData = $response->getData();

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_FORBIDDEN);
        // check content response data
        $this->assertEquals($responseData->error, '権限エラー');
    }

    public function testRefreshOK()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $serviceMock     = new Service([
            'id'    => 1,
            'name'  => 'service testing',
            'token' => 'yyyy-yyyy-yyyy-yyyy',
        ]);
        $serviceMock->id = 1;
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => $this->uriCorporationId,
            'group_id'       => $this->uriGroupId,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);

        // mock AuthenticationLogic->checkContract() return true
        $authenticationLogic->shouldReceive('checkContract')->andReturn(true);

        // mock save login return Token record after saved
        $token = new Token([
            'token'      => 'xxxx-xxxx-xxxx-xxxx',
            'expires_in' => 1587465190
        ]);
        $authenticationLogic->shouldReceive('saveLogin')->andReturn($token);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $response = $this->callApi([], [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization' => 'xxxx-xxxx-xxxx-xxxx'
        ]);

        // check http status
        // check response json value
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'access_token' => 'xxxx-xxxx-xxxx-xxxx',
                'token_type'   => 'bearer',
                'expires_in'   => 1587465190
            ]);
    }
}
