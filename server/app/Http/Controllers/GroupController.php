<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ValidateGroupHelper;
use App\Http\Logics\GroupLogic;
use App\Http\Models\Corporation;
use App\Http\Models\Group;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Validator;

/**
 * Class GroupController
 *
 * @package App\Http\Controllers
 */
class GroupController extends Controller
{
    private GroupLogic $groupLogic;

    /**
     * GroupController constructor.
     *
     * @param GroupLogic $groupLogic
     */
    public function __construct(GroupLogic $groupLogic)
    {
        $this->groupLogic = $groupLogic;
    }

    /**
     * Show list group of corporation as tree view
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $corporations = Corporation::all();

        if ($request->corporation_id) {
            $corporationSelected = $corporations->find($request->corporation_id);
        } else {
            $corporationSelected = $corporations->first();
        }

        $groups = $corporationSelected->groups->whereNull('parent_group_id');

        return view('group.index', compact('corporations', 'corporationSelected', 'groups'));
    }

    /**
     * Create list group of corporation
     *
     * @param Request $request
     * @param $corporationId
     * @return Factory|View
     */
    public function create(Request $request, $corporationId)
    {
        $corporation = Corporation::findOrFail($corporationId);
        $groups      = $corporation->groups->whereNull('parent_group_id');
        return view('group.create', compact('corporation', 'groups'));
    }

    /**
     * Store group
     *
     * @param Request $request
     * @param $corporationId
     * @return mixed
     */
    public function store(Request $request, $corporationId)
    {
        $parameters = [
            'corporation_id'  => $corporationId,
            'parent_group_id' => $request->parent_group_id,
            'name'            => $request->name
        ];

        $validator = Validator::make(
            $parameters,
            ValidateGroupHelper::getCreateRules(),
            [],
            trans('tool/group.attributes')
        );
        if ($validator->fails()) {
            return back()
                ->with('error_message', trans('tool/group.message.create_fail'))
                ->withErrors($validator)
                ->withInput();
        }

        $group = $this->groupLogic->store($parameters);

        if (! $group) {
            Session::flash('error_message', trans('tool/group.message.create_fail'));
        } else {
            Session::flash('success_message', trans('tool/group.message.create_success'));
        }

        return back();
    }

    /**
     * Edit group
     *
     * @param Request $request
     * @param $groupId
     * @return Factory|View
     */
    public function edit(Request $request, $groupId)
    {
        $groupEdit   = Group::with('corporation')->findOrFail($groupId);
        $corporation = $groupEdit->corporation;
        $groups      = $corporation->groups
            ->whereNull('parent_group_id')
            ->where('id', '<>', $groupId);

        return view('group.create', compact('corporation', 'groups', 'groupEdit'));
    }

    /**
     * Update group
     *
     * @param Request $request
     * @param $groupId
     * @return mixed
     */
    public function update(Request $request, $groupId)
    {
        $parameters = [
            'group_id'        => $groupId,
            'parent_group_id' => $request->parent_group_id,
            'name'            => $request->name,
        ];

        $validator = Validator::make(
            $parameters,
            ValidateGroupHelper::getUpdateRules(),
            [],
            trans('tool/group.attributes')
        );
        if ($validator->fails()) {
            return back()
                ->with('error_message', trans('tool/group.message.create_fail'))
                ->withErrors($validator)
                ->withInput();
        }

        $group = $this->groupLogic->update($parameters);
        if ( ! $group) {
            Session::flash('error_message', trans('tool/group.message.update_fail'));
        } else {
            Session::flash('success_message', trans('tool/group.message.update_success'));
        }

        return back();
    }
}
