<?php

namespace Tests\Feature\Api;

use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginTest
 *
 * @package Tests\Feature\Api
 */
class LoginTest extends BaseTest
{
    protected function setUp(): void
    {
        $this->uri = '/api/auth/login';
        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @return array
     */
    public function validateParamNGProvider()
    {
        return [
            [
                // login_id
                [
                    'login_id' => '***',
                    'password' => 'xxx'
                ],
                [
                    'target'  => 'login_id',
                    'message' => 'login idには、有効な正規表現を指定してください。'
                ]
            ],
            [
                // login_id contain [1lIoO0]
                [
                    'login_id' => 'Co2-xyz71',
                    'password' => 'xxx'
                ],
                [
                    'target'  => 'login_id',
                    'message' => 'login idには、有効な正規表現を指定してください。'
                ]
            ],
            [
                // password
                [
                    'login_id' => 'Cd2-xyz78',
                    'password' => ''
                ],
                [
                    'target'  => 'password',
                    'message' => 'パスワードは、必ず指定してください。'
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

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyServiceTokenNGProvider
     */
    public function testVerifyServiceTokenNG($headers, $expected)
    {
        parent::verifyServiceTokenNG($headers, $expected);
    }

    public function testLoginNG401()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $serviceMock = new Service([
            "name"  => "service testing",
            "token" => "yyyy-yyyy-yyyy-yyyy",
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock AuthenticationLogic->checAuth() return false
        $authenticationLogic->shouldReceive('getAuth')->andReturn(null);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        // request params valid
        $requestParams = [
            'login_id' => 'Ab2-cde34',
            'password' => 'password',
        ];
        $headers       = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];
        $response      = $this->post($this->uri, $requestParams, $headers);
        $responseData  = $response->getData();

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_UNAUTHORIZED);
        // check content response data
        $this->assertEquals($responseData->error, '認証エラー');
    }

    public function testLoginNG403()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $serviceMock = new Service([
            "name"  => "service testing",
            "token" => "yyyy-yyyy-yyyy-yyyy",
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock AuthenticationLogic->getAuth() return account object
        $authenticationLogic->shouldReceive('getAuth')->andReturn(new Account());

        // mock AuthenticationLogic->checkContract() return false
        $authenticationLogic->shouldReceive('checkContract')->andReturn(false);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        // request params valid
        $requestParams = [
            'login_id' => 'Ab2-cde34',
            'password' => 'password',
        ];
        $headers       = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];
        $response      = $this->postJson($this->uri, $requestParams, $headers);
        $responseData  = $response->getData();

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_FORBIDDEN);
        // check content response data
        $this->assertEquals($responseData->error, '権限エラー');
    }

    public function testLoginOK()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return Service object mock
        $serviceMock = new Service([
            "name"  => "service testing",
            "token" => "yyyy-yyyy-yyyy-yyyy",
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        // mock AuthenticationLogic->getAuth() return object account
        $authenticationLogic->shouldReceive('getAuth')->andReturn(new Account());

        // mock AuthenticationLogic->checkContract() return true
        $authenticationLogic->shouldReceive('checkContract')->andReturn(true);

        // mock save login return Token record after saved
        $token = new Token([
            'token'      => 'xxxx-xxxx-xxxx-xxxx',
            'expires_in' => 1587465190
        ]);
        $authenticationLogic->shouldReceive('saveLogin')->andReturn($token);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        // request params valid
        $requestParams = [
            'login_id' => 'Ab2-cde34',
            'password' => 'password',
        ];
        $headers       = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];
        $response      = $this->postJson($this->uri, $requestParams, $headers);

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
