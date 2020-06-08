<?php

namespace Tests\Feature\api;

use App\Http\Logics\Api\CorporationLogic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CountActiveAccountsTest
 *
 * @package Tests\Feature\api
 */
class CountActiveAccountsTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1/active/accounts';
        $this->httpMethod = 'get';
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testCountActiveAccountsOK()
    {
        parent::mockGetToken();

        $this->partialMock(CorporationLogic::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('countShikakumapActiveAccounts')->andReturn(123);
        });

        $headers  = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi([], $headers);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['total']);
        $this->assertEquals(123, $response['total']);
    }

    public function testCountActiveAccountsNG()
    {
        parent::mockGetToken();

        $this->partialMock(CorporationLogic::class, function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('countShikakumapActiveAccounts')->andThrowExceptions([new ModelNotFoundException]);
        });

        $headers  = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response = $this->callApi([], $headers);

        $response->assertStatus(Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /*
    |--------------------------------------------------------------------------
    | Middleware testing
    |--------------------------------------------------------------------------
    */

    public function testLinkageCodeNG()
    {
        $this->verifyLinkageCodeNG();
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
}
