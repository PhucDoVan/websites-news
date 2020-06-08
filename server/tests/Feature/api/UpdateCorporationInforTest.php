<?php


namespace Tests\Feature\Api;

use App\Http\Logics\Api\CorporationLogic;
use App\Http\Models\Corporation;
use App\Http\Models\CorporationContact;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateCorporationInforTest
 *
 * @package Tests\Feature\Api
 */
class UpdateCorporationInforTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1';
        $this->httpMethod = 'put';
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
                // postal is numeric
                [
                    'postal' => 1234567
                ],
                [
                    'target'  => 'postal',
                    'message' => 'postalには、文字を指定してください。'
                ]
            ],
            [
                // corporation address_pref container than 50 characters
                [
                    'address_pref' => '株式会社アイムービック株式会社アイムービック株式会社アイムービック株式会社アイムービック株式会社アイムービック',
                ],
                [
                    'target'  => 'address_pref',
                    'message' => '都道府県は、50文字以下にしてください。'
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

    public function testUpdateFail()
    {
        parent::mockGetToken(true);
        parent::mockPermission(true);

        $this->uri = '/api/v1/corporations/3';

        $headers = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];

        $response     = $this->callApi([], $headers);
        $responseData = $response->getData();

        //  check http status
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        //  check message error
        $this->assertEquals('リソースが見つかりません', $responseData->error);
    }

    public function testUpdateCorporationInforOK()
    {
        parent::mockGetToken(true);
        parent::mockPermission(true);

        $corporationModel                = Mockery::mock(CorporationLogic::class);
        $contact                         = new CorporationContact();
        $contact->corporation_contact_id = 1;
        $contact->corporation_id         = 1;
        $contact->name                   = null;
        $contact->tel                    = '0899341939';
        $contact->email                  = 'info@example.com';
        $contact->fax                    = null;

        $corporationMock                 = new Corporation();
        $corporationMock->corporation_id = 1;
        $corporationMock->name           = '株式会社アイムービック';
        $corporationMock->kana           = 'アイムービック';
        $corporationMock->uid            = 'K7b';
        $corporationMock->postal         = '1234567';
        $corporationMock->address_pref   = '愛媛県';
        $corporationMock->address_city   = '松山市';
        $corporationMock->address_town   = '千舟町';
        $corporationMock->address_etc    = null;
        $corporationMock->contacts       = [$contact];
        $corporationModel->shouldReceive('updateInformation')->andReturn($corporationMock);
        $this->app->instance(CorporationLogic::class, $corporationModel);

        $headers = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];

        $requestParams = [
            'postal' => '1234567'
        ];

        $expected = [
            'id'           => 1,
            'name'         => '株式会社アイムービック',
            'kana'         => 'アイムービック',
            'uid'          => 'K7b',
            'postal'       => '1234567',
            'address_pref' => '愛媛県',
            'address_city' => '松山市',
            'address_town' => '千舟町',
            'address_etc'  => null,
            'contacts'     => [
                0 => [
                    'id'             => 1,
                    'corporation_id' => 1,
                    'name'           => null,
                    'tel'            => '0899341939',
                    'email'          => 'info@example.com',
                    'fax'            => null
                ]
            ]
        ];
        $response = $this->callApi($requestParams, $headers);

        //  check http status
        $response->assertStatus(Response::HTTP_OK);
        //  check message error
        $response->assertJson($expected);
    }
}
