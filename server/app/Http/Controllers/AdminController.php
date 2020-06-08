<?php

namespace App\Http\Controllers;

use App\Http\Logics\AdminLogic;
use App\Http\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Helpers\ValidateAdminHelper;
use Validator;

class AdminController extends Controller
{
    private $adminLogic = null;

    /**
     * ManagerController constructor.
     */
    public function __construct()
    {
        $this->adminLogic = new AdminLogic();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $formData                   = $request->all(['keyword', 'sort_column', 'sort_direction']);
        $formData['keyword']        = $formData['keyword'] ?? '';
        $formData['sort_column']    = $formData['sort_column'] ?? session(SESSION_ADMIN_SORT_COLUMN, 'manager_id');
        $formData['sort_direction'] = $formData['sort_direction'] ?? session(SESSION_ADMIN_SORT_DIRECTION, 'asc');

        session()->put(SESSION_ADMIN_INDEX_URL, url()->full());
        session()->put(SESSION_ADMIN_SORT_COLUMN, $formData['sort_column']);
        session()->put(SESSION_ADMIN_SORT_DIRECTION, $formData['sort_direction']);

        $managers = $this->adminLogic->getList($formData['keyword'], $formData['sort_column'],
            $formData['sort_direction']);
        if ($managers->count() === 0 && $managers->total() > 0) {
            return redirect(session(SESSION_ADMIN_INDEX_URL) . '&page=' . $managers->lastPage());
        }
        return view('admin.index', [
            'formData' => $formData,
            'managers' => $managers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        // Validate request parameters
        $validator = Validator::make($request->all(), ValidateAdminHelper::getStoreRules());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(Input::except('password'));
        }

        $manager = $this->adminLogic->store(collect($request->all()));
        if ($manager === false) {
            // Store Manager Error
            return back()->with('error_message',
                trans('tool/admins.message.error_create'))->withInput(Input::except('password'));
        }
        return redirect(route('admin.create'))
            ->with('success_message', trans('tool/admins.message.success_create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $managerId
     * @return \Illuminate\Http\Response
     */
    public function edit($managerId)
    {
        // Validate request parameters
        $validator = Validator::make(['manager_id' => $managerId], ValidateAdminHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ADMIN_INDEX_URL))->withErrors($validator)->withInput();
        }
        // Get data info
        $manager = Manager::find($managerId);

        // Response
        return view('admin.create', [
            'manager' => $manager,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $managerId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $managerId)
    {
        // Validate manager_id
        $validator = Validator::make(['manager_id' => $managerId], ValidateAdminHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ADMIN_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Validate request parameters
        $validator = Validator::make($request->all(), ValidateAdminHelper::getUpdateRules($managerId));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(Input::except('password'));
        }

        $manager = $this->adminLogic->update($managerId, collect($request->all()));
        if ($manager === false) {
            // Store Manager Error
            return back()->with('error_message',
                trans('tool/admins.message.error_update'))->withInput(Input::except('password'));
        }
        return redirect(route('admin.edit', $managerId))
            ->with('success_message', trans('tool/admins.message.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $managerId
     * @return \Illuminate\Http\Response
     */
    public function destroy($managerId)
    {
        $validator = Validator::make(['manager_id' => $managerId], ValidateAdminHelper::getDeleteRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ADMIN_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Delete manager
        if ($this->adminLogic->destroy($managerId) === false) {
            return back()->with('error_message', trans('tool/admins.message.error_delete'));
        }
        return back()->with('success_message', trans('tool/admins.message.success_delete'));
    }
}
