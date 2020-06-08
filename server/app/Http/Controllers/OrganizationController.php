<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Validator;
use App\Http\Helpers\ValidateOrganizationHelper;
use App\Http\Logics\OrganizationLogic;
use App\Http\Models\Corporation;

class OrganizationController extends Controller
{
    private $organizationLogic;

    /**
     * OrganizationController constructor.
     *
     * @param OrganizationLogic $organizationLogic
     */
    public function __construct(OrganizationLogic $organizationLogic)
    {
        $this->organizationLogic = $organizationLogic;
    }

    /**
     * Return view organization list
     *
     * @param Request $request
     * @return Factory|RedirectResponse|Redirector|View
     * @author nvmanh.sgt@gmail.com
     */
    public function index(Request $request)
    {
        $formData                   = $request->all(['keyword', 'sort_column', 'sort_direction']);
        $formData['keyword']        = $formData['keyword'] ?? '';
        $formData['sort_column']    = $formData['sort_column'] ?? session(SESSION_ORGANIZATION_SORT_COLUMN,
                'corporation_id');
        $formData['sort_direction'] = $formData['sort_direction'] ?? session(SESSION_ORGANIZATION_SORT_DIRECTION,
                'asc');

        session()->put(SESSION_ORGANIZATION_INDEX_URL, url()->full());
        session()->put(SESSION_ORGANIZATION_SORT_COLUMN, $formData['sort_column']);
        session()->put(SESSION_ORGANIZATION_SORT_DIRECTION, $formData['sort_direction']);

        $corporations = $this->organizationLogic->getList($formData['keyword'], $formData['sort_column'],
            $formData['sort_direction']);
        if ($corporations->count() === 0 && $corporations->total() > 0) {
            // Redirect to page with search condition
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL) . '&page=' . $corporations->lastPage());
        }
        return view('organization.index', [
            'formData'     => $formData,
            'corporations' => $corporations,
        ]);
    }

    /**
     * Return view register new organization
     *
     * @return Factory|View
     * @author nvmanh.sgt@gmail.com
     */
    public function create()
    {
        return view('organization.create');
    }

    /**
     * Store organization
     *
     * @param Request $request
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ValidateOrganizationHelper::getCreateOrganizationRules(), [],
            trans('tool/organization.attributes'));

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $organization = $this->organizationLogic->store($request->all());

        if ($organization) {
            // Store Organization Success
            Session::flash('success_message', trans('tool/organization.message.create_success'));
        } else {
            // Store Organization Error
            Session::flash('error_message', trans('tool/organization.message.create_fail'));
        }

        return back();
    }

    /**
     * Return view merge duplicate records organization
     *
     * @param $request
     * @param $organizationId
     * @return mixed
     * @author dttien.sgt@gmail.com
     */
    public function merge(Request $request, $organizationId)
    {
        $validator = Validator::make(['corporation_id' => $organizationId],
            ValidateOrganizationHelper::getEditOrganizationRules());

        if ($validator->fails()) {
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $organization = Corporation::find($organizationId);
        if ( ! $organization) {
            // Get organization fail
            Session::flash('error_message', trans('tool/organization.message.get_error'));
            return view('organization.merge');
        }

        $keyword = $request->input('keyword');
        if ($keyword) {
            $organizations = $this->organizationLogic->getDuplicateByKeyword($organizationId, $keyword);
        } else {
            $organizations = $this->organizationLogic->getDuplicateByEntity($organization);
        }

        return view('organization.merge', [
            "keyword"       => $keyword,
            "organization"  => $organization,
            "organizations" => $organizations
        ]);
    }

    /**
     * Execute merge
     *
     * @param Request $request
     * @param $corporationId
     * @return mixed
     */
    public function executeMerge(Request $request, $corporationId)
    {
        $validator = Validator::make(['corporation_id' => $corporationId],
            ValidateOrganizationHelper::getEditOrganizationRules());

        $corporationIdMerge = $request->input('corporation_id_merge');
        if ( ! $validator->fails()) {
            $validator = Validator::make(['corporation_id' => $corporationIdMerge],
                ValidateOrganizationHelper::getEditOrganizationRules());
        }

        if ($validator->fails()) {
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $idTarget = $corporationId;
        $idSource = $corporationIdMerge;
        if ($request->input('merge_to') == 'right') {
            $idTarget = $corporationIdMerge;
            $idSource = $corporationId;
        }

        $mergeResult = $this->organizationLogic->merge($idTarget, $idSource);
        if ($mergeResult === false) {
            // Merge Corporation Error
            return back()->with('error_message',
                trans('tool/organization.message.merge_fail'))->withInput();
        }

        return redirect()->route('organization.merge-duplicate', [
            $idTarget,
            'keyword' => $request->input('keyword')
        ])->with('success_message', trans('tool/organization.message.merge_success'));
    }

    /**
     * Return view edit organization
     *
     * @param $organizationId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function edit($organizationId)
    {
        $validator = Validator::make(['corporation_id' => $organizationId],
            ValidateOrganizationHelper::getEditOrganizationRules());

        if ($validator->fails()) {
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $organization = Corporation::find($organizationId);
        if ( ! $organization) {
            // Get organization fail
            Session::flash('error_message', trans('tool/organization.message.get_error'));
            return view('organization.create');
        }

        return view('organization.create', ["organization" => $organization]);
    }

    /**
     * Update for organization
     *
     * @param Request $request
     * @param $organizationId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function update(Request $request, $organizationId)
    {
        $validator = Validator::make(['corporation_id' => $organizationId],
            ValidateOrganizationHelper::getEditOrganizationRules());

        if ($validator->fails()) {
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        // Custom rules
        $validator = Validator::make($request->all(),
            ValidateOrganizationHelper::getUpdateOrganizationRules($organizationId), [],
            trans('tool/organization.attributes'));

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $organizationResult = $this->organizationLogic->updateOrganization($request->all(), $organizationId);
        if ($organizationResult) {
            // Store organization success
            Session::flash('success_message', trans('tool/organization.message.update_success'));

            return back()->with("organization", $organizationResult);
        }
        // Store organization error
        Session::flash('error_message', trans('tool/organization.message.update_fail'));

        return back()->withInput();
    }

    /**
     * Update corporation service status
     *
     * @param Request $request
     * @param $organizationId
     * @return mixed
     */
    public function updateServiceStatus(Request $request, $organizationId)
    {
        $validator = Validator::make(['corporation_id' => $organizationId],
            ValidateOrganizationHelper::getEditOrganizationRules());

        if ($validator->fails()) {
            // corporation_id not exists
            Session::flash('error_message', trans('tool/organization.message.update_fail'));
            return back();
        }

        // Custom rules
        $validator = Validator::make($request->all(), ValidateOrganizationHelper::getUpdateServiceStatusRules());
        if ($validator->fails()) {
            Session::flash('error_message', trans('tool/organization.message.update_fail'));
            return back();
        }

        $serviceId          = $request->service_id;
        $status             = $request->status;
        $this->organizationLogic->updateServiceStatus($organizationId, $serviceId, $status);

        // Store statis success
        Session::flash('success_message', trans('tool/organization.message.update_success'));
        return back();
    }

    /**
     * Delete organization
     *
     * @param $organizationId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function destroy($organizationId)
    {
        $validator = Validator::make(['corporation_id' => $organizationId],
            ValidateOrganizationHelper::getDeleteOrganizationRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ORGANIZATION_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Delete organization
        if ($this->organizationLogic->deleteOrganization($organizationId) === false) {
            // Delete organization fail
            return back()->with('error_message', trans('tool/organization.message.delete_fail'));
        }

        // Delete organization success
        return back()->with('success_message', trans('tool/organization.message.delete_success'));
    }
}
