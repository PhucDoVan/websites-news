<?php


namespace Tests\Feature\Api;

use App\Http\Logics\Api\CorporationServiceLogic;
use Mockery;
use App\Http\Models\CorporationService;
use App\Enums\CorporationServiceStatus;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateServiceContractStatusTest
 * TODO:test api database
 *
 * @package Tests\Feature\Api
 */
class UpdateServiceContractStatusTest extends BaseTest
{
    protected function setup(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1/status';
        $this->httpMethod = 'put';
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function validateParamNGProvider()
    {
        return [
            [
                //  Status null
                [
                    'status' => ''
                ],
                [
                    'target'  => 'status',
                    'message' => 'statusは、必ず指定してください。'
                ]
            ],
            [
                //  Status fail
                [
                    'status' => 'abc'
                ],
                [
                    'target'  => 'status',
                    'message' => '選択されたstatusは、有効ではありません。'
                ]
            ],
            [
                //  Status fail define
                [
                    'status' => 3
                ],
                [
                    'target'  => 'status',
                    'message' => '選択されたstatusは、有効ではありません。'
                ]
            ]
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

    public function testUpdateNG404()
    {
        parent::mockGetToken();
        parent::mockPermission(true);

        $corporationService = Mockery::mock('alias:App\Http\Models\CorporationService');
        $corporationService->shouldReceive('findByCorporationID')->andReturnNull();
        $this->app->instance('App\Http\Models\CorporationService', $corporationService);

        $headers       = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $requestParams = [
            'status' => 2
        ];
        $response      = $this->callApi($requestParams, $headers);
        $responseData  = $response->getData();

        // check http status
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        // check content response data
        $this->assertEquals($responseData->error, 'リソースが見つかりません');
    }

    public function testUpdateOK()
    {
        parent::mockGetToken();
        parent::mockPermission(true);

        $corporationService  = Mockery::mock('alias:App\Http\Models\CorporationService');
        $serviceMock         = new CorporationService([
            'service_id'     => 1,
            'corporation_id' => 1,
        ]);
        $serviceMock->status = CorporationServiceStatus::ACTIVE;
        $corporationService->shouldReceive('findByCorporationID')->andReturn($serviceMock);
        $this->app->instance('App\Http\Models\CorporationService', $corporationService);

        $corporationServiceLogic = Mockery::mock(CorporationServiceLogic::class);
        $corporationServiceLogic->shouldReceive('updateStatus')->andReturnTrue();
        $this->app->instance(CorporationServiceLogic::class, $corporationServiceLogic);

        $headers       = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $requestParams = [
            'status' => CorporationServiceStatus::RESTRICTED
        ];
        $response      = $this->callApi($requestParams, $headers);

        // check http status
        $response->assertStatus(Response::HTTP_OK);
    }
}
