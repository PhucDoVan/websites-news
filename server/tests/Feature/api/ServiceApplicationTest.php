<?php


namespace Tests\Feature\Api;

use App\Enums\CorporationServiceStatus;
use App\Http\Logics\Api\AccountLogic;
use App\Http\Logics\Api\CorporationContactLogic;
use App\Http\Logics\Api\CorporationLogic;
use App\Http\Logics\Api\CorporationServiceLogic;
use App\Http\Logics\Api\GroupLogic;
use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\CorporationContact;
use App\Http\Models\CorporationService;
use App\Http\Models\Group;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

class ServiceApplicationTest extends BaseTest
{
    protected function setUp(): void
    {
        $this->uri = '/api/v1/application';
        parent::setUp();
        $this->seed();
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * mock for generate:
     * - corporation uid: K7b
     * - account username: ab123
     * - account password: a1b2c3d4e5
     */
    private function mockGenerateHelper()
    {
        $helper = Mockery::mock('alias:App\Http\Helpers\GenerateHelper');
        // mock generate corporation.uuid
        $helper->shouldReceive('generateLoginId')
            ->with(3)
            ->andReturn('K7b');
        // mock generate account.username
        $helper->shouldReceive('generateLoginId')
            ->with(5)
            ->andReturn('ab123');
        // mock generate account.password
        $helper->shouldReceive('generatePassword')
            ->with(10)
            ->andReturn('a1b2c3d4e5');
        $this->app->instance('App\Http\Helpers\GenerateHelper', $helper);
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

    public function validateParamsNGProvider()
    {
        return [
            [
                //  Corporation's information is null
                [
                    'corporation' => [
                        'name'         => '',
                        'kana'         => '',
                        'postal'       => '',
                        'address_pref' => '',
                        'address_city' => '',
                        'address_town' => '',
                        'address_etc'  => '',
                        'tel'          => '',
                        'email'        => ''
                    ],
                    'account'     => [
                        'last_name'  => '⼭⽥',
                        'first_name' => '太郎',
                        'last_kana'  => 'ヤマダ',
                        'first_kana' => 'タロウ'
                    ],
                    'contract'    => [
                        'reason' => 'JONからの営業'
                    ]
                ],
                [
                    [
                        'target'  => 'corporation.name',
                        'message' => 'corporation.nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.kana',
                        'message' => 'corporation.kanaは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.postal',
                        'message' => 'corporation.postalは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_pref',
                        'message' => 'corporation.address prefは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_city',
                        'message' => 'corporation.address cityは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_town',
                        'message' => 'corporation.address townは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.tel',
                        'message' => 'corporation.telは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.email',
                        'message' => 'corporation.emailは、必ず指定してください。'
                    ],
                ]
            ],
            [
                //  Account's information is null
                [
                    'corporation' => [
                        'name'         => '株式会社アイムービック',
                        'kana'         => 'アイムービック',
                        'postal'       => '7900011',
                        'address_pref' => '愛媛県',
                        'address_city' => '松⼭市',
                        'address_town' => '千⾈町',
                        'address_etc'  => '',
                        'tel'          => '0899341939',
                        'email'        => 'info@eyemovic.com'
                    ],
                    'account'     => [
                        'last_name'  => '',
                        'first_name' => '',
                        'last_kana'  => '',
                        'first_kana' => ''
                    ],
                    'contract'    => [
                        'reason' => 'JONからの営業'
                    ]
                ],
                [
                    [
                        'target'  => 'account.last_name',
                        'message' => 'account.last nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.first_name',
                        'message' => 'account.first nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.last_kana',
                        'message' => 'account.last kanaは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.first_kana',
                        'message' => 'account.first kanaは、必ず指定してください。'
                    ],
                ]
            ],
            [
                //  Account's information & Corporation's information are null
                [
                    'corporation' => [
                        'name'         => '',
                        'kana'         => '',
                        'postal'       => '',
                        'address_pref' => '',
                        'address_city' => '',
                        'address_town' => '',
                        'address_etc'  => '',
                        'tel'          => '',
                        'email'        => ''
                    ],
                    'account'     => [
                        'last_name'  => '',
                        'first_name' => '',
                        'last_kana'  => '',
                        'first_kana' => ''
                    ],
                    'contract'    => [
                        'reason' => 'JONからの営業'
                    ]
                ],
                [
                    [
                        'target'  => 'corporation.name',
                        'message' => 'corporation.nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.kana',
                        'message' => 'corporation.kanaは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.postal',
                        'message' => 'corporation.postalは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_pref',
                        'message' => 'corporation.address prefは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_city',
                        'message' => 'corporation.address cityは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.address_town',
                        'message' => 'corporation.address townは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.tel',
                        'message' => 'corporation.telは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'corporation.email',
                        'message' => 'corporation.emailは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.last_name',
                        'message' => 'account.last nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.first_name',
                        'message' => 'account.first nameは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.last_kana',
                        'message' => 'account.last kanaは、必ず指定してください。'
                    ],
                    [
                        'target'  => 'account.first_kana',
                        'message' => 'account.first kanaは、必ず指定してください。'
                    ],
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
        $this->withoutMiddleware();

        $response = $this->post($this->uri, $requestParams);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'error' => $expected
            ]);
    }

    public function testDuplicateCorporationUid()
    {
        parent::mockGetToken(false, true);
        $this->mockGenerateHelper();

        $corporationLogic = Mockery::mock(CorporationLogic::class);
        // mock CorporationLogic->getCorporationByUID() return false
        $corporationLogic->shouldReceive('generateUID')->andReturn(false);
        $this->app->instance(CorporationLogic::class, $corporationLogic);

        $requestParams = [
            'corporation' => [
                'name'         => '株式会社アイムービック',
                'kana'         => 'アイムービック',
                'postal'       => '7900011',
                'address_pref' => '愛媛県',
                'address_city' => '松⼭市',
                'address_town' => '千⾈町',
                'address_etc'  => '',
                'tel'          => '0899341939',
                'email'        => 'info@eyemovic.com'
            ],
            'account'     => [
                'last_name'  => '⼭⽥',
                'first_name' => '太郎',
                'last_kana'  => 'ヤマダ',
                'first_kana' => 'タロウ'
            ],
            'contract'    => [
                'reason' => 'JONからの営業'
            ]
        ];
        $requestHeader = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];

        $response     = $this->callApi($requestParams, $requestHeader);
        $responseData = $response->getData();
        $this->assertEquals($response->status(), Response::HTTP_SERVICE_UNAVAILABLE);
        $this->assertEquals($responseData->error, 'サーバー側でエラーが発生');
    }

    public function testDuplicateUsername()
    {
        parent::mockGetToken(false, true);
        $this->mockGenerateHelper();

        $corporationLogic = Mockery::mock(CorporationLogic::class);
        // mock CorporationLogic->getCorporationByUID() return string
        $corporationLogic->shouldReceive('generateUID')->andReturn('ABC');
        $this->app->instance(CorporationLogic::class, $corporationLogic);

        $accountLogic = Mockery::mock(AccountLogic::class);
        // mock AccountLogic->generateUsername() return false
        $accountLogic->shouldReceive('generateUsername')->andReturn(false);
        $this->app->instance(AccountLogic::class, $accountLogic);

        $requestParams = [
            'corporation' => [
                'name'         => '株式会社アイムービック',
                'kana'         => 'アイムービック',
                'postal'       => '7900011',
                'address_pref' => '愛媛県',
                'address_city' => '松⼭市',
                'address_town' => '千⾈町',
                'address_etc'  => '',
                'tel'          => '0899341939',
                'email'        => 'info@eyemovic.com'
            ],
            'account'     => [
                'last_name'  => '⼭⽥',
                'first_name' => '太郎',
                'last_kana'  => 'ヤマダ',
                'first_kana' => 'タロウ'
            ],
            'contract'    => [
                'reason' => 'JONからの営業'
            ]
        ];
        $requestHeader = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];

        $response     = $this->callApi($requestParams, $requestHeader);
        $responseData = $response->getData();
        $this->assertEquals($response->status(), Response::HTTP_SERVICE_UNAVAILABLE);
        $this->assertEquals($responseData->error, 'サーバー側でエラーが発生');
    }

    public function createOKProvider()
    {
        return [
            [
                [
                    'corporation' => [
                        'name'         => '株式会社アイムービック',
                        'kana'         => 'アイムービック',
                        'postal'       => '7900011',
                        'address_pref' => '愛媛県',
                        'address_city' => '松⼭市',
                        'address_town' => '千⾈町',
                        'address_etc'  => '',
                        'tel'          => '0899341939',
                        'email'        => 'info@eyemovic.com'
                    ],
                    'account'     => [
                        'last_name'  => '⼭⽥',
                        'first_name' => '太郎',
                        'last_kana'  => 'ヤマダ',
                        'first_kana' => 'タロウ'
                    ],
                    'contract'    => [
                        'reason' => 'JONからの営業'
                    ]
                ],
                [
                    'id'           => 1,
                    'name'         => '株式会社アイムービック',
                    'kana'         => 'アイムービック',
                    'uid'          => 'K7b',
                    'postal'       => '7900011',
                    'address_pref' => '愛媛県',
                    'address_city' => '松山市',
                    'address_town' => '千舟町',
                    'address_etc'  => null,
                    'contact'      => [
                        'id'             => 1,
                        'corporation_id' => 1,
                        'name'           => null,
                        'tel'            => '0899341939',
                        'email'          => 'info@eyemovic.com',
                        'fax'            => null
                    ],
                    'account'      => [
                        'id'         => 1,
                        'name_last'  => '山田',
                        'name_first' => '太郎',
                        'kana_last'  => 'ヤマダ',
                        'kana_first' => 'タロウ',
                        'username'   => 'K7b-ab123',
                        'password'   => 'a1b2c3d4e5'
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider createOKProvider
     * @param $requestParams
     * @param $expected
     */
    public function testCreateOK($requestParams, $expected)
    {
        parent::mockGetToken(false, true);
        $this->mockGenerateHelper();

        $corporationLogic = Mockery::mock(CorporationLogic::class);
        // mock CorporationLogic->generateUID() return K7b
        $corporationLogic->shouldReceive('generateUID')->andReturn('K7b');

        // mock CorporationLogic->store() return Corporation object
        $corporationMock                 = new Corporation();
        $corporationMock->corporation_id = 1;
        $corporationMock->name           = '株式会社アイムービック';
        $corporationMock->uid            = 'K7b';
        $corporationMock->kana           = 'アイムービック';
        $corporationMock->postal         = '7900011';
        $corporationMock->address_pref   = '愛媛県';
        $corporationMock->address_city   = '松山市';
        $corporationMock->address_town   = '千舟町';
        $corporationMock->address_etc    = null;
        $corporationLogic->shouldReceive('store')->andReturn($corporationMock);
        $this->app->instance(CorporationLogic::class, $corporationLogic);

        $accountLogic = Mockery::mock(AccountLogic::class);
        // mock AccountLogic->generateUsername() return null
        $accountLogic->shouldReceive('generateUsername')->andReturn('K7b-ab123');

        $accountMock             = new Account([
            'name_last'  => '山田',
            'name_first' => '太郎',
            'kana_last'  => 'ヤマダ',
            'kana_first' => 'タロウ',
            'username'   => 'K7b-ab123',
            'password'   => 'a1b2c3d4e5'
        ]);
        $accountMock->account_id = 1;
        $accountLogic->shouldReceive('store')->andReturn($accountMock);
        $this->app->instance(AccountLogic::class, $accountLogic);

        // mock CorporationContact->store() return CorporationContact object
        $corporationContact                             = Mockery::mock(CorporationContactLogic::class);
        $corporationContactMock                         = new CorporationContact([
            'corporation_id' => 1,
            'name'           => null,
            'tel'            => '0899341939',
            'email'          => 'info@eyemovic.com',
            'fax'            => null
        ]);
        $corporationContactMock->corporation_contact_id = 1;
        $corporationContact->shouldReceive('store')->andReturn($corporationContactMock);
        $this->app->instance(CorporationContactLogic::class, $corporationContact);

        // mock CorporationServiceLogic->store() return CorporationService object
        $corporationServiceLogic = Mockery::mock(CorporationServiceLogic::class);
        $corporationServiceLogic->shouldReceive('store')->andReturn(new CorporationService([
            'corporation_id' => 1,
            'service_id'     => 1,
            'status'         => CorporationServiceStatus::ACTIVE,
        ]));
        $this->app->instance(CorporationServiceLogic::class, $corporationServiceLogic);

        // mock GroupLogic->store() return Group object
        $groupLogic = Mockery::mock(GroupLogic::class);
        $groupLogic->shouldReceive('store')->andReturn(new Group([
            'corporation_id' => 1,
            'name'           => GroupLogic::GROUP_NAME_DEFAULT,
        ]));
        $this->app->instance(GroupLogic::class, $groupLogic);

        $requestHeader = [
            'X-SERVICE-TOKEN' => 'yyyy-yyyy-yyyy-yyyy'
        ];

        $response = $this->callApi($requestParams, $requestHeader);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($expected);
    }
}
