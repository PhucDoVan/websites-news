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
        return User::with('profiles')
            ->find($userId);
    }

    public function upsertProfiles(Request $request, Profile $profiles)
    {
        $parameters = $request->all();
        DB::beginTransaction();
        try {
            $profiles->fill($parameters);
            $profiles->user_id = Auth::user()->id;

//            if ($parameters['avatar_tmp'] && $this->moveImage($parameters['avatar_tmp'])) {
//                $profiles->avatar = $parameters['avatar_tmp'];
//            }
            $profiles->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('WebLogic.upsertNews', $exception->getTrace());
            return false;
        }
    }

    public function moveImage($path)
    {
        $oldPath = Upload::TmpPath.$path;
        $newPath = Upload::UploadPath.$path;
        return File::move($oldPath, $newPath);
    }
}
