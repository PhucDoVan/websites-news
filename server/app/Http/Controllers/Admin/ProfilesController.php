<?php

namespace App\Http\Controllers\Admin;

use App\Logic\WebLogic;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public $webLogic = null;

    public function __construct(WebLogic $webLogic)
    {
        $this->webLogic       = $webLogic;
    }

    public function getProfiles()
    {
        $userId     = Auth::user()->id;
        $profiles      = $this->webLogic->getDetailProfile($userId);
        if (! $profiles) {
            abort(Response::HTTP_NOT_FOUND);
        }
        return view('admin.profiles.index', [
            'profiles'       => $profiles
        ]);
    }

    public function postProfiles(Request $request, Profile $profile )
    {
        $this->webLogic->upsertProfiles( $request, $profile);
        return redirect()->route('admin.profiles');
    }
}
