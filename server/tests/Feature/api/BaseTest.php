<?php

namespace Tests\Feature\Api;

use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Logics\Api\PermissionLogic;
use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Class BaseTest
 *
 * @package Tests\Feature\Api
 */
abstract class BaseTest extends TestCase
{
    use RefreshDatabase;

    protected string $httpMethod            = 'post';
    protected string $uri                   = '';
    protected int    $uriCorporationId      = 1;
    protected int    $uriGroupId            = 1;
    protected bool   $isRequiredLinkageCode = false;

    /**
     * @param array $parameters
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function callApi($parameters = [], $headers = [])
    {
        $httpMethod = strtolower($this->httpMethod);
        $uri        = $this->uri;
        if ($httpMethod === 'get') {
            $uri = $uri . '?' . http_build_query($parameters);
            return $this->get($uri, $headers);
        } else {
            return $this->{$httpMethod}($uri, $parameters, $headers);
        }
    }

    protected function mockGetToken($isServiceTokenNull = false, $isAccessTokenNull = false)
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        $serviceMock         = null;
        if ( ! $isServiceTokenNull) {
            // mock AuthenticationLogic->getServiceByToken() return Service object mock
            $serviceMock     = new Service([
                'id'    => 1,
                'name'  => 'service testing',
                'token' => 'yyyy-yyyy-yyyy-yyyy',
            ]);
            $serviceMock->id = 1;
        }
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceMock);

        $tokenObject = null;
        if ( ! $isAccessTokenNull) {
            // mock AuthenticationLogic->getServiceByToken() return Service object mock
            $tokenObject          = new Token([
                'token' => 'xxxx-xxxx-xxxx-xxxx'
            ]);
            $tokenObject->account = new Account([
                'corporation_id' => $this->uriCorporationId,
                'group_id'       => $this->uriGroupId,
            ]);
        }
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);
    }

    protected function mockPermission(bool $value = true)
    {
        $permissionLogic = Mockery::mock(PermissionLogic::class);
        // mock PermissionLogic->getServiceByToken() return false
        $permissionLogic->shouldReceive('checkPermission')->andReturn($value);
        $this->app->instance(PermissionLogic::class, $permissionLogic);
    }

    /**
     * @return array
     */
    public function verifyServiceTokenNGProvider()
    {
        return [
            [
                // service token null
                [
                    'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
                ],
                [
                    'status_code' => Response::HTTP_NOT_FOUND,
                    'message'     => 'リソースが見つかりません'
                ]
            ],
            [
                // service token empty
                [
                    'X-SERVICE-TOKEN' => '',
                    'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
                ],
                [
                    'status_code' => Response::HTTP_NOT_FOUND,
                    'message'     => 'リソースが見つかりません'
                ]
            ],
            [
                // service token fail
                [
                    'X-SERVICE-TOKEN' => 'token-fail',
                    'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
                ],
                [
                    'status_code' => Response::HTTP_NOT_FOUND,
                    'message'     => 'リソースが見つかりません'
                ]
            ],
        ];
    }

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyServiceTokenNGProvider
     */
    public function verifyServiceTokenNG($headers, $expected)
    {
        $this->mockGetToken(true);

        $response     = $this->callApi([], $headers);
        $responseData = $response->getData();

        // check http status
        $this->assertEquals($response->status(), $expected['status_code']);
        // check content response data
        $this->assertEquals($responseData->error, $expected['message']);
    }

    /**
     * @return array
     */
    public function verifyAccessTokenNGProvider()
    {
        return [
            [
                // access token null
                [
                    'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
            [
                // access token fail
                [
                    'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
                    'Authorization'   => 'Bearer token-fail'
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
        ];
    }

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyAccessTokenNGProvider
     */
    public function verifyAccessTokenNG($headers, $expected)
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return service object
        $serviceObject = new Service([
            'token' => $headers['X-SERVICE-TOKEN']
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceObject);

        // mock AuthenticationLogic->getAccessToken() return null
        $authenticationLogic->shouldReceive('getAccessToken')->andReturnNull();
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $response     = $this->callApi([], $headers);
        $responseData = $response->getData();

        // check http status
        $this->assertEquals($response->status(), $expected['status_code']);
        // check content response data
        $this->assertEquals($responseData->error, $expected['message']);
    }

    public function verifyLinkageCodeRequiredNGProvider()
    {
        return [
            [
                // linkage code null
                [
                    'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
            [
                // linkage code fail
                [
                    'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
                    'X-LINKAGE-CODE'  => 'Linkage code fail',
                    'Authorization'   => 'Bearer token-passed'
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
        ];
    }

    public function verifyLinkageCodeOptionalNGProvider()
    {
        return [
            [
                // linkage code & access token null
                [
                    'X-LINKAGE-CODE' => '',
                    'Authorization'  => '',
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
            [
                // linkage code null & access token fail
                [
                    'X-LINKAGE-CODE' => '',
                    'Authorization'  => 'access token fail',
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
            [
                // linkage code false & access token null
                [
                    'X-LINKAGE-CODE' => 'Linkage code fail',
                    'Authorization'  => '',
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
            [
                // linkage code & access token fail
                [
                    'X-LINKAGE-CODE'  => 'Linkage code fail',
                    'Authorization'   => 'Bearer token fail'
                ],
                [
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'message'     => '認証エラー'
                ]
            ],
        ];
    }

    public function verifyLinkageCodeNG()
    {
        if ($this->isRequiredLinkageCode) {
            $providers = $this->verifyLinkageCodeRequiredNGProvider();
        } else {
            $providers = $this->verifyLinkageCodeOptionalNGProvider();
        }

        foreach ($providers as $provider) {
            $headers  = $provider[0];
            $expected = $provider[1];

            $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
            // mock AuthenticationLogic->getServiceByToken() return service object
            $serviceObject = new Service([
                'token' => $headers['Authorization']
            ]);
            $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceObject);

            // mock AuthenticationLogic->getAccessToken() return null
            $authenticationLogic->shouldReceive('getAccessToken')->andReturnNull();
            $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

            $response     = $this->callApi([], $headers);
            $responseData = $response->getData();

            // check http status
            $this->assertEquals($response->status(), $expected['status_code']);
            // check content response data
            $this->assertEquals($responseData->error, $expected['message']);
        }
    }

    public function verifyUriParamNG()
    {
        $authenticationLogic = Mockery::mock(AuthenticationLogic::class);
        // mock AuthenticationLogic->getServiceByToken() return service object
        $serviceObject = new Service([
            'token' => 'yyyy-yyyy-yyyy-yyyy'
        ]);
        $authenticationLogic->shouldReceive('getServiceByToken')->andReturn($serviceObject);

        // mock AuthenticationLogic->getAccessToken() return token object
        $tokenObject          = new Token([
            'token' => 'xxxx-xxxx-xxxx-xxxx'
        ]);
        $tokenObject->account = new Account([
            'corporation_id' => 9999999,
            'group_id'       => 9999999,
        ]);
        $authenticationLogic->shouldReceive('getAccessToken')->andReturn($tokenObject);
        $this->app->instance(AuthenticationLogic::class, $authenticationLogic);

        $requestHeaders = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response       = $this->callApi([], $requestHeaders);
        $responseData   = $response->getData();

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_NOT_FOUND);
        // check content response data
        $this->assertEquals($responseData->error, 'リソースが見つかりません');
    }

    public function checkPermissionNG()
    {
        $this->mockGetToken();
        $this->mockPermission(false);

        $requestHeaders = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response       = $this->callApi([], $requestHeaders);
        $responseData   = $response->getData();

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_FORBIDDEN);
        // check content response data
        $this->assertEquals($responseData->error, '権限エラー');
    }

    /**
     * @return array
     */
    public function validateParamNGProvider()
    {
        return [];
    }

    /**
     * @param $requestParams
     * @param $expected
     * @dataProvider validateParamNGProvider
     */
    public function validateParamsNG($requestParams, $expected)
    {
        $this->withoutMiddleware();

        $response      = $this->callApi($requestParams);
        $responseData  = $response->getData();
        $responseError = $responseData->error;

        $listErrorTarget  = array_column($responseError, 'target');
        $listErrorMessage = array_column($responseError, 'message');

        // check http status
        $this->assertEquals($response->status(), Response::HTTP_UNPROCESSABLE_ENTITY);
        // check content response data
        $this->assertContains($expected["target"], $listErrorTarget);
        $this->assertContains($expected["message"], $listErrorMessage);
    }
}
