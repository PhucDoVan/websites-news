<?php


namespace App\Http\Logics\Api;

use App\Http\Helpers\GenerateHelper;
use App\Http\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AccountLogic
{
    /**
     * Create an account
     *
     * @param $parameters
     * @return Account
     */
    public function store($parameters)
    {
        $parameters['password']                 = Hash::make($parameters['password']);
        $parameters['shikakumap_registered_at'] = Carbon::now();

        $account             = new Account($parameters);
        $account->name_last  = $parameters['last_name'];
        $account->name_first = $parameters['first_name'];
        $account->kana_last  = $parameters['last_kana'];
        $account->kana_first = $parameters['first_kana'];
        $account->save();
        $account->roles()->attach($parameters['role_id']);

        return $account;
    }

    public function generateUsername($uid, $retries = 1)
    {
        do {
            $username    = $uid . '-' . GenerateHelper::generateLoginId(5);
            $isDuplicate = ! empty(Account::findByUsername($username));
            $retries--;
        } while ($isDuplicate && $retries > 0);

        return ($isDuplicate && $retries <= 0) ? false : $username;
    }
}
