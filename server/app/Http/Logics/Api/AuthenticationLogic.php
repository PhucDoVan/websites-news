<?php

namespace App\Http\Logics\Api;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Models\Token;
use App\Http\Models\Service;
use App\Http\Models\Account;
use App\Http\Models\CorporationService;
use App\Enums\CorporationServiceStatus;

class AuthenticationLogic
{
    /**
     * expire after 168 hours (7 days)
     */
    public const EXPIRY_HOURS = 168;

    /**
     * @param $token
     * @param Service $service |null
     * @return mixed
     */
    public function getAccessToken($token, $service = null)
    {
        $token = Token::where('token', $token)
            ->where('expires_in', '>', Carbon::now());

        if ($service) {
            $token->where('service_id', $service->id);
        }

        return $token->first();
    }

    /**
     * @param $token
     * @return mixed
     */
    public function getServiceByToken($token)
    {
        return Service::where('token', $token)->first();
    }

    /**
     * @param $credentials
     * @return Account|null
     */
    public function getAuth($credentials)
    {
        $guard = Auth::guard('account');
        $guard->attempt($credentials);

        return $guard->user();
    }

    /**
     * check corporation service contract
     *
     * @param $corporationId
     * @param $serviceId
     * @return mixed
     */
    public function checkContract($corporationId, $serviceId)
    {
        $corporationService = CorporationService::where([
            'corporation_id' => $corporationId,
            'service_id'     => $serviceId,
        ])
            ->where(function ($query) {
                $query->where('terminated_at', '>', Carbon::now())
                    ->orWhereNull('terminated_at');
            })
            ->first();

        return in_array(optional($corporationService)->status, [
            CorporationServiceStatus::ACTIVE,
            CorporationServiceStatus::RESTRICTED,
        ], true);
    }

    /**
     * @param $accountId
     * @param $serviceId
     * @return mixed
     */
    public function saveLogin($accountId, $serviceId)
    {
        $token  = Str::uuid()->toString();
        $expire = Carbon::now()->addHours(self::EXPIRY_HOURS);

        return Token::updateOrCreate(
            [
                'account_id' => $accountId,
                'service_id' => $serviceId
            ],
            [
                'token'      => $token,
                'expires_in' => $expire
            ]
        );
    }

    /**
     * delete access token
     *
     * @param $accountId
     * @param $serviceId
     * @return bool | null
     */
    public function logout($accountId, $serviceId)
    {
        return Token::where([
            'account_id' => $accountId,
            'service_id' => $serviceId
        ])
            ->delete();
    }

    /**
     * Update access tokens expires by Corporation's terminate datetime
     *
     * @param $corporationId
     * @param $datetime
     * @return mixed
     */
    public function updateExpireByCorporationTerminate($corporationId, $datetime)
    {
        return Token::join('accounts', 'tokens.account_id', '=', 'accounts.account_id')
            ->where('accounts.corporation_id', $corporationId)
            ->where('tokens.expires_in', '>', $datetime)
            ->update([
                'tokens.expires_in' => $datetime
            ]);
    }
}
