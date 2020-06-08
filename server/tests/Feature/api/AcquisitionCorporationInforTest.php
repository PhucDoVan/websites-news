<?php


namespace Tests\Feature\Api;

use App\Http\Models\Corporation;
use App\Http\Models\CorporationContact;
use App\Http\Resources\CorporationInformationResource;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AcquisitionCorporationInforTest
 *
 * @package Tests\Feature\Api
 */
class AcquisitionCorporationInforTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->uri        = '/api/v1/corporations/1';
        $this->httpMethod = 'get';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
        // set JsonResource wrapper to default after each unit test case
        CorporationInformationResource::wrap('data');
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

    public function testLinkageCodeNG()
    {
        $this->verifyLinkageCodeNG();
    }

    public function testGetInformationFail()
    {
        parent::mockGetToken(true);
        parent::mockPermission(true);

        $this->uri = '/api/v1/corporations/3';

        $headers      = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $response     = $this->callApi([], $headers);
        $responseData = $response->getData();

        //  check http status
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        //  check message error
        $this->assertEquals('リソースが見つかりません', $responseData->error);
    }

    /**
     * Test linkage code null & accessToken right
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGetInformationOK()
    {
        parent::mockGetToken(true, false);
        parent::mockPermission(true);

        $corporationModel                = Mockery::mock('alias:App\Http\Models\Corporation');
        $contact                         = new CorporationContact([
            'corporation_id' => 1,
            'name'           => null,
            'tel'            => '123-4567-8901',
            'email'          => 'abc@example.com',
            'fax'            => null
        ]);
        $contact->corporation_contact_id = 1;

        $corporationMock                 = new Corporation();
        $corporationMock->corporation_id = 1;
        $corporationMock->name           = '株式会社 エー・ビー・シー';
        $corporationMock->kana           = 'アイムービック';
        $corporationMock->uid            = 'Ab7';
        $corporationMock->postal         = '9200907';
        $corporationMock->address_pref   = '⽯川県';
        $corporationMock->address_city   = '⾦沢市';
        $corporationMock->address_town   = '⻘草町';
        $corporationMock->address_etc    = null;
        $corporationMock->contacts       = [
            $contact
        ];
        $corporationModel->shouldReceive('with')->andReturn($corporationModel);
        $corporationModel->shouldReceive('find')->andReturn($corporationMock);
        $this->app->instance('App\Http\Models\Corporation', $corporationModel);

        $headers  = [
            'Authorization' => 'Bearer xxxx-xxxx-xxxx-xxxx'
        ];
        $expected = [
            'id'           => 1,
            'name'         => '株式会社 エー・ビー・シー',
            'kana'         => 'アイムービック',
            'uid'          => 'Ab7',
            'postal'       => '9200907',
            'address_pref' => '⽯川県',
            'address_city' => '⾦沢市',
            'address_town' => '⻘草町',
            'address_etc'  => null,
            'contacts'     => [
                [
                    'id'             => 1,
                    'corporation_id' => 1,
                    'name'           => null,
                    'tel'            => '123-4567-8901',
                    'email'          => 'abc@example.com',
                    'fax'            => null
                ]
            ]
        ];
        $response = $this->callApi([], $headers);

        // check http status
        $response->assertStatus(Response::HTTP_OK);
        // check response json
        $response->assertJson($expected);
    }
}
