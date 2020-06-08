<?php

namespace Tests\Feature\Api;

use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LogoutTest
 *
 * @package Tests\Feature\Api
 */
class LogoutTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri = '/api/auth/logout';
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

    public function testLogoutOK()
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

        // mock AuthenticationLogic->logout() return true
        $authenticationLogic->shouldReceive('logout')->andReturnTrue();
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $response = $this->callApi([], [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization' => 'xxxx-xxxx-xxxx-xxxx'
        ]);

        // check http status
        $response->assertStatus(Response::HTTP_OK);
    }
}
