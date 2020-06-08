<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ValidateServiceHelper;
use App\Http\Logics\ServiceLogic;
use App\Http\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

/**
 * Class ServiceController
 *
 * @package App\Http\Controllers
 */
class ServiceController extends Controller
{
    private $serviceLogic;

    /**
     * ServiceController constructor.
     *
     * @param ServiceLogic $serviceLogic
     */
    public function __construct(ServiceLogic $serviceLogic)
    {
        $this->serviceLogic = $serviceLogic;
    }

    /**
     * Return view service list
     *
     * @param Request $request
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function index(Request $request)
    {
        $formData                   = $request->all(['keyword', 'sort_column', 'sort_direction']);
        $formData['keyword']        = $formData['keyword'] ?? '';
        $formData['sort_column']    = $formData['sort_column'] ?? session(SESSION_SERVICE_SORT_COLUMN,
                'id');
        $formData['sort_direction'] = $formData['sort_direction'] ?? session(SESSION_SERVICE_SORT_DIRECTION,
                'asc');

        session()->put(SESSION_SERVICE_INDEX_URL, url()->full());
        session()->put(SESSION_SERVICE_SORT_COLUMN, $formData['sort_column']);
        session()->put(SESSION_SERVICE_SORT_DIRECTION, $formData['sort_direction']);

        $services = $this->serviceLogic->getList($formData['keyword'], $formData['sort_column'],
            $formData['sort_direction']);
        if ($services->count() === 0 && $services->total() > 0) {
            // Redirect to page with search condition
            return redirect(session(SESSION_SERVICE_INDEX_URL) . '&page=' . $services->lastPage());
        }
        return view('service.index', [
            'formData' => $formData,
            'services' => $services,
        ]);
    }

    /**
     * Return view register new service
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author nvmanh.sgt@gmail.com
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Store service
     *
     * @param Request $request
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function store(Request $request)
    {
        $rules     = ValidateServiceHelper::getCreateServiceRules();
        $validator = Validator::make($request->all(), $rules, [], trans('tool/service.attributes'));

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $service = $this->serviceLogic->store($request->all());

        if ($service) {
            // Store Service Success
            Session::flash('success_message', trans('tool/service.message.create_success'));
        } else {
            // Store Service Error
            Session::flash('error_message', trans('tool/service.message.create_fail'));
        }

        return back();
    }

    /**
     * Return view edit service
     *
     * @param $serviceId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function edit($serviceId)
    {
        $validator = Validator::make(['service_id' => $serviceId], ValidateServiceHelper::getEditServiceRules());

        if ($validator->fails()) {
            return redirect(session(SESSION_SERVICE_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $service = Service::find($serviceId);
        if ( ! $service) {
            // Get service fail
            Session::flash('error_message', trans('tool/service.message.get_error'));
            return view('service.create');
        }

        return view('service.create', ["service" => $service]);
    }

    /**
     * Update for service
     *
     * @param Request $request
     * @param $serviceId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function update(Request $request, $serviceId)
    {
        $validator = Validator::make(['service_id' => $serviceId], ValidateServiceHelper::getEditServiceRules());

        if ($validator->fails()) {
            return redirect(session(SESSION_SERVICE_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        // Custom rules
        $rules     = ValidateServiceHelper::getUpdateServiceRules($serviceId);
        $validator = Validator::make($request->all(), $rules, [], trans('tool/service.attributes'));

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $serviceResult = $this->serviceLogic->updateService($request, $serviceId);
        if ($serviceResult) {
            // Store service success
            Session::flash('success_message', trans('tool/service.message.update_success'));

            return back()->with("service", $serviceResult);
        }
        // Store service error
        Session::flash('error_message', trans('tool/service.message.update_fail'));

        return back()->withInput();
    }

    /**
     * Delete service
     *
     * @param $serviceId
     * @return mixed
     * @author nvmanh.sgt@gmail.com
     */
    public function destroy($serviceId)
    {
        $validator = Validator::make(['service_id' => $serviceId], ValidateServiceHelper::getDeleteServiceRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_SERVICE_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Delete service
        if ($this->serviceLogic->deleteService($serviceId) === false) {
            // Delete service fail
            return back()->with('error_message', trans('tool/service.message.delete_fail'));
        }

        // Delete service success
        return back()->with('success_message', trans('tool/service.message.delete_success'));
    }
}
