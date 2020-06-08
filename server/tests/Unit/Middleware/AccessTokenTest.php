<?php

namespace Tests\Unit\Middleware;

use App\Enums\UriParameterType;
use App\Exceptions\ApiException;
use App\Http\Logics\Api\AuthenticationLogic;
use App\Http\Middleware\AccessToken;
use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\Group;
use App\Http\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\BaseTest;

/**
 * Class AccessTokenTest
 *
 * @package Tests\Unit\Middleware\AccessTokenTest
 * @group middleware
 */
class AccessTokenTest extends BaseTest
{
    use RefreshDatabase;

    public function testRequiredAccessToken()
    {
        $request    = Request::create('/api/v1/test', 'GET');
        $middleware = new AccessToken(new AuthenticationLogic);

        try {
            $middleware->handle($request, function () {
            });
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_UNAUTHORIZED),
            $e
        );
    }

    public function testAccessTokenNG()
    {
        factory(Token::class)->create([
            'token' => 'access-token-valid'
        ]);

        $request = Request::create('/api/v1/test', 'GET');
        $request->headers->set('Authorization', 'access-token-fail');
        $middleware = new AccessToken(new AuthenticationLogic);

        try {
            $middleware->handle($request, function () {
            });
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_UNAUTHORIZED),
            $e
        );
    }

    public function testCorporationParamNG()
    {
        $account = factory(Account::class)->create([
            'corporation_id' => factory(Corporation::class)->create([
                'corporation_id' => 9999
            ]),
        ]);
        factory(Token::class)->create([
            'account_id' => $account->account_id,
            'token'      => 'access-token-valid'
        ]);

        $request                 = Request::create('/api/v1/test', 'GET');
        $request->corporation_id = 2;
        $request->headers->set('Authorization', 'access-token-valid');
        $middleware = new AccessToken(new AuthenticationLogic);

        try {
            $middleware->handle($request, function () {
            }, UriParameterType::CORPORATION);
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_NOT_FOUND),
            $e
        );
    }

    public function testGroupParamNG()
    {
        $account = factory(Account::class)->create([
            'group_id' => factory(Group::class)->create([
                'id' => 9999
            ]),
        ]);
        factory(Token::class)->create([
            'account_id' => $account->account_id,
            'token'      => 'access-token-valid'
        ]);

        $request           = Request::create('/api/v1/test', 'GET');
        $request->group_id = 2;
        $request->headers->set('Authorization', 'access-token-valid');
        $middleware = new AccessToken(new AuthenticationLogic);

        try {
            $middleware->handle($request, function () {
            }, UriParameterType::GROUP);
        } catch (\Throwable $e) {
        }

        $this->assertEquals(
            new ApiException(Response::HTTP_NOT_FOUND),
            $e
        );
    }

    public function testAccessTokenOk()
    {
        $account = factory(Account::class)->create([
            'corporation_id' => factory(Corporation::class)->create([
                'corporation_id' => 9999
            ]),
        ]);
        factory(Token::class)->create([
            'account_id' => $account->account_id,
            'token'      => 'access-token-valid'
        ]);

        $request                 = Request::create('/api/v1/test', 'GET');
        $request->corporation_id = 9999;
        $request->headers->set('Authorization', 'access-token-valid');
        $middleware = new AccessToken(new AuthenticationLogic);

        $response = $middleware->handle($request, function () {
        }, UriParameterType::CORPORATION);

        $this->assertEquals($request->attributes->get('account')->toArray(), $account->toArray());
        $this->assertNull($response);
    }

    public function testLinkageCodeOk()
    {
        $request = Request::create('/api/v1/test', 'GET');
        $request->attributes->add(['linkage_code' => 'linkage-code-valid']);
        $request->headers->set('Authorization', 'access-token-valid');
        $request->headers->set('X-LINKAGE-CODE', 'linkage-code-valid');
        $middleware = new AccessToken(new AuthenticationLogic);

        $response = $middleware->handle($request, function () {
        }, UriParameterType::CORPORATION);

        $this->assertNull($response);
    }
}
