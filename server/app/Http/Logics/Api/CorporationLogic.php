<?php


namespace App\Http\Logics\Api;

use App\Http\Helpers\GenerateHelper;
use App\Http\Models\Corporation;

class CorporationLogic
{
    /**
     * Create a corporation
     *
     * @param $parameters
     * @return Corporation
     */
    public function store($parameters)
    {
        $corporation = new Corporation($parameters);
        $corporation->save();

        return $corporation;
    }

    /**
     * @param int $retries
     * @return bool|string
     */
    public function generateUID($retries = 1)
    {
        do {
            $uid         = GenerateHelper::generateLoginId(3);
            $isDuplicate = ! empty(Corporation::findByUID($uid));
            $retries--;
        } while ($isDuplicate && $retries > 0);

        return ($isDuplicate && $retries <= 0) ? false : $uid;
    }

    /**
     * Update corporation information
     *
     * @param $corporationId
     * @param $parameters
     * @return array
     */
    public function updateInformation($corporationId, $parameters)
    {
        $corporation = Corporation::findOrFail($corporationId);
        $corporation->fill($parameters);
        $corporation->save();

        return $corporation;
    }

    /**
     * Count "ShikakuMap" active accounts by corporation
     *
     * @param $corporationId
     * @return mixed
     */
    public function countShikakumapActiveAccounts($corporationId)
    {
        return Corporation::findOrFail($corporationId)
            ->accounts()
            ->where(function ($query) {
                // "シカクマップ登録日時"が先月以前
                $query->where('shikakumap_registered_at', '<', now()->firstOfMonth())
                    // かつ"シカクマップ解除日時"がNULLの場合
                    ->whereNull('shikakumap_deregistered_at');
            })
            ->orWhere(function ($query) {
                // "シカクマップ解除日時"が当月1日〜月末の期間の場合
                $query->where('shikakumap_deregistered_at', '>=', now()->firstOfMonth())
                    ->where('shikakumap_deregistered_at', '<=', now()->endOfMonth());
            })
            ->count();
    }
}
