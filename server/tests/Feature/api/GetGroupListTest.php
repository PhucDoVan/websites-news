<?php


namespace Tests\Feature\Api;

use App\Http\Logics\Api\GroupLogic;
use App\Http\Models\Group;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetDepartmentListTest
 *
 * @package Tests\Feature\Api
 */
class GetGroupListTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1/groups';
        $this->httpMethod = 'get';
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function validateParamsNGProvider()
    {
        return [
            [
                //  page not is numeric
                [
                    'page'            => 'abc',
                    'limit'           => '',
                    'parent_group_id' => '',
                    'group_ids'       => '1,2,4'
                ],
                [
                    'target'  => 'page',
                    'message' => 'pageには、数字を指定してください。'
                ]
            ],
            [
                //  limit not is numeric
                [
                    'page'            => '1',
                    'limit'           => 'abc',
                    'parent_group_id' => '',
                    'group_ids'       => '1,2,4'
                ],
                [
                    'target'  => 'limit',
                    'message' => 'limitには、数字を指定してください。'
                ]
            ],
            [
                //  size of group_ids > 50
                [
                    'page'            => '1',
                    'limit'           => '',
                    'parent_group_id' => '',
                    'group_ids'       => '1,2,4,1,2,4,1,2,4,1,2,4,2,4,1,2,4,1,2,4,2,4,1,2,4,1,2,4,1,2,4,2,4,1,2,4,1,2,4,1,2,4,2,4,1,2,4,1,2,4,1'
                ],
                [
                    'target'  => 'group_ids',
                    'message' => 'group idsの項目は、50個以下にしてください。'
                ]
            ],
        ];
    }

    /**
     * @param $requestParams
     * @param $expected
     * @dataProvider validateParamsNGProvider
     */
    public function testValidateParamsNG($requestParams, $expected)
    {
        parent::validateParamsNG($requestParams, $expected);
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

    public function testGetListOK()
    {
        parent::mockGetToken(true, false);
        parent::mockPermission(true);

        $groupData = [
            ['id' => 1, 'name' => 'A部門', 'corporation_id' => 1, 'parent_group_id' => null,],
            ['id' => 2, 'name' => 'B部門', 'corporation_id' => 1, 'parent_group_id' => null,],
            ['id' => 4, 'name' => 'A-1部門', 'corporation_id' => 1, 'parent_group_id' => 1,]
        ];

        $groupLogic = Mockery::mock(GroupLogic::class);
        $groupsMock = [];
        foreach ($groupData as $data) {
            $groupObj     = new Group($data);
            $groupObj->id = $data['id'];
            $groupsMock[] = $groupObj;
        }

        $mockData = new LengthAwarePaginator($groupsMock, 50, 15, 1, [
            'path'     => 'http://localhost/api/v1/corporations/1/groups',
            'pageName' => 'page'
        ]);

        $groupLogic->shouldReceive('getListByCorporationId')->andReturn($mockData);
        $this->app->instance(GroupLogic::class, $groupLogic);

        $header   = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $expected = [
            'data'  => [
                [
                    'id'              => 1,
                    'name'            => 'A部門',
                    'corporation_id'  => 1,
                    'parent_group_id' => null
                ],
                [
                    'id'              => 2,
                    'name'            => 'B部門',
                    'corporation_id'  => 1,
                    'parent_group_id' => null
                ],
                [
                    'id'              => 4,
                    'name'            => 'A-1部門',
                    'corporation_id'  => 1,
                    'parent_group_id' => 1
                ]
            ],
            'links' => [
                'first' => 'http://localhost/api/v1/corporations/1/groups?page=1',
                'last'  => 'http://localhost/api/v1/corporations/1/groups?page=4',
                'next'  => 'http://localhost/api/v1/corporations/1/groups?page=2',
                'prev'  => null
            ],
            'meta'  => [
                'total'        => 50,
                'per_page'     => 15,
                'current_page' => 1,
                'last_page'    => 4,
                'path'         => 'http://localhost/api/v1/corporations/1/groups',
                'from'         => 1,
                'to'           => 3
            ],
        ];
        $response = $this->callApi([], $header);
        // check http status
        $response->assertStatus(Response::HTTP_OK);
        // check response json
        $response->assertJson($expected);
    }
}
