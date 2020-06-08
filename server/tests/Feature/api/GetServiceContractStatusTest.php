<?php


namespace Tests\Feature\Api;

use App\Enums\CorporationServiceStatus;
use App\Http\Models\CorporationService;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetServiceContractStatus
 *
 * @package Tests\Feature\Api
 */
class GetServiceContractStatusTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1/status';
        $this->httpMethod = 'get';
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

    public function testCheckPermissionNG()
    {
        parent::checkPermissionNG();
    }

    public function testVerifyUriParamNG()
    {
        parent::verifyUriParamNG();
    }

    public function testGetStatusNG404()
    {
        parent::mockGetToken(true);
        parent::mockPermission(true);

        $headers  = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi([], $headers);

        // check http status
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testGetStatusOK()
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

        $headers  = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
            'Authorization'   => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi([], $headers);

        // check http status
        $response->assertStatus(Response::HTTP_OK);
        // check response json
        $response->assertJson(['status' => 1]);
    }
}
