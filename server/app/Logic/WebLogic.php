<?php

namespace App\Logic;

use App\Enums\Property\Upload;
use App\Models\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Log;

class WebLogic
{
    public function getDetailProfile($userId)
    {
        return Profile::where('user_id', $userId)->get();
    }

    public function upsertProfiles($parameters)
    {
        $userId = Auth::user()->id;
        DB::connection('mysql')->beginTransaction();
        try {
            foreach ($parameters['user_profiles'] as $key => $profiles) {
                $profile = new Profile();
                $isExistImage  = file_exists(Upload::UploadPath.$profiles['image_tmp']);
                if (! ($isExistImage || ($profiles['image_tmp'] && $this->moveImage($profiles['image_tmp'])))) {
                    continue;
                }
                $profiles['user_id']   = $userId;
                $profiles['avatar'] = $profiles['image_tmp'];

                $profile::updateOrCreate(
                    ['id' => data_get($profiles, 'id')],
                    $profiles
                );
            }
            DB::connection('mysql')->commit();
            return true;
        } catch (\Exception $exception) {
            DB::connection('mysql')->rollBack();
            Log::error('WebLogic.upsertProfiles', $exception->getTrace());
            return false;
        }
    }

    public function moveImage($path)
    {
        $oldPath = Upload::TmpPath . $path;
        $newPath = Upload::UploadPath . $path;
        return File::move($oldPath, $newPath);
    }
}
