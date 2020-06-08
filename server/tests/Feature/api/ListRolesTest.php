<?php

namespace Tests\Feature\api;

use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListRolesTest
 *
 * @package Tests\Feature\api
 */
class ListRolesTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/roles';
        $this->httpMethod = 'get';
        $this->seed();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testListRolesOK()
    {
        parent::mockGetToken();

        $headers = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy',
        ];

        $this->callApi([], $headers)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'service_id',
                        'label',
                        'name',
                    ]
                ]
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Middleware testing
    |--------------------------------------------------------------------------
    */

    /**
     * @param $headers
     * @param $expected
     * @dataProvider verifyServiceTokenNGProvider
     */
    public function testVerifyServiceTokenNG($headers, $expected)
    {
        parent::verifyServiceTokenNG($headers, $expected);
    }
}
