<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ValidateAccountHelper;
use App\Http\Logics\AccountLogic;
use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\Service;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Validator;

class AccountController extends Controller
{
    private AccountLogic $accountLogic;

    /**
     * AccountController constructor.
     *
     * @param AccountLogic $accountLogic
     */
    public function __construct(AccountLogic $accountLogic)
    {
        $this->accountLogic = $accountLogic;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function index(Request $request)
    {
        $formData                   = $request->all(['keyword', 'sort_column', 'sort_direction']);
        $formData['keyword']        = $formData['keyword'] ?? '';
        $formData['sort_column']    = $formData['sort_column'] ?? session(SESSION_ACCOUNT_SORT_COLUMN, 'account_id');
        $formData['sort_direction'] = $formData['sort_direction'] ?? session(SESSION_ACCOUNT_SORT_DIRECTION, 'asc');

        session()->put(SESSION_ACCOUNT_INDEX_URL, url()->full());
        session()->put(SESSION_ACCOUNT_SORT_COLUMN, $formData['sort_column']);
        session()->put(SESSION_ACCOUNT_SORT_DIRECTION, $formData['sort_direction']);

        $accounts = $this->accountLogic->getList($formData['keyword'], $formData['sort_column'],
            $formData['sort_direction']);
        if ($accounts->count() === 0 && $accounts->total() > 0) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL) . '&page=' . $accounts->lastPage());
        }
        return view('account.index', [
            'formData' => $formData,
            'accounts' => $accounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        $corporations = Corporation::all();
        return view('account.create', [
            'corporations' => $corporations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function store(Request $request)
    {
        // Validate request parameters
        $validator = Validator::make($request->all(), ValidateAccountHelper::getStoreRules(), [],
            trans('tool/accounts.attributes'));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password'));
        }

        $account = $this->accountLogic->store($request->all());
        if ($account === false) {
            // Store Account Error
            return back()->with('error_message',
                trans('tool/accounts.message.error_create'))->withInput($request->except('password'));
        }

        $redirectSuccess = redirect(route('account.create'))
            ->with('success_message', trans('tool/accounts.message.success_create'));

        if ($request->input('continue_register')) {
            return $redirectSuccess->withInput($request->only([
                'corporation_id',
                'restrict_ips'
            ]));
        }

        return $redirectSuccess;
    }

    /**
     * Return view merge duplicate records account
     *
     * @param $request
     * @param $accountId
     * @return mixed
     * @author dttien.sgt@gmail.com
     */
    public function merge(Request $request, $accountId)
    {
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $account = $this->accountLogic->getAccountWithCorporation($accountId);

        if ( ! $account) {
            // Get account fail
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->with('error_message', trans('tool/accounts.message.error_get'));
        }

        $keyword = $request->input('keyword');
        if ($keyword) {
            $accounts = $this->accountLogic->getDuplicateByKeyword($accountId, $keyword);
        } else {
            $accounts = $this->accountLogic->getDuplicateByEntity($account);
        }

        return view('account.merge', [
            "keyword"  => $keyword,
            "account"  => $account,
            "accounts" => $accounts
        ]);
    }

    /**
     * Execute merge
     *
     * @param Request $request
     * @param $accountId
     * @return mixed
     */
    public function executeMerge(Request $request, $accountId)
    {
        $validator = Validator::make(['account_id' => $accountId],
            ValidateAccountHelper::getEditRules());

        $accountIdMerge = $request->input('account_id_merge');
        if ( ! $validator->fails()) {
            $validator = Validator::make(['account_id' => $accountIdMerge],
                ValidateAccountHelper::getEditRules());
        }

        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $idTarget = $accountId;
        $idSource = $accountIdMerge;
        if ($request->input('merge_to') == 'right') {
            $idTarget = $accountIdMerge;
            $idSource = $accountId;
        }

        $mergeResult = $this->accountLogic->merge($idTarget, $idSource);
        if ($mergeResult === false) {
            // Merge Account Error
            return back()->with('error_message',
                trans('tool/accounts.message.error_merge'))->withInput();
        }

        return redirect()->route('account.merge-duplicate', [
            $idTarget,
            'keyword' => $request->input('keyword')
        ])->with('success_message', trans('tool/accounts.message.success_merge'));
    }

    /**
     * Return view import histories account
     *
     * @param $accountId
     * @return mixed
     * @author dttien.sgt@gmail.com
     */
    public function importHistories($accountId)
    {
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        $account = $this->accountLogic->getAccountWithCorporation($accountId);

        if ( ! $account) {
            // Get account fail
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->with('error_message', trans('tool/accounts.message.error_get'));
        }

        $services = Service::all();

        return view('account.import-histories', [
            'account'  => $account,
            'services' => $services
        ]);
    }

    /**
     * Upload & validate file histories
     *
     * @param $request
     * @param $accountId
     * @return mixed
     * @author dttien.sgt@gmail.com
     */
    public function uploadHistories(Request $request, $accountId)
    {
        // validate account id
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))
                ->withErrors($validator)
                ->withInput();
        }

        // validate file uploaded
        $fileHistory = $request->file('file_history');
        $validator   = Validator::make(
            ['file_history' => $fileHistory],
            ValidateAccountHelper::getUploadFileHistoriesRules(),
            [],
            trans('tool/accounts.attributes.import_histories')
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // read content file
        $fileContents = file($fileHistory, FILE_IGNORE_NEW_LINES);
        if ( ! is_array($fileContents)) {
            return back()->with('error_message', trans('tool/accounts.message.error_upload'))->withInput();
        }

        // validate file content by line
        $validator = Validator::make(
            ['file_content' => $fileContents],
            ValidateAccountHelper::getContentFileHistoriesRules(),
            trans('validation.custom.file_history_content')
        );

        // get list index error by keys
        $contentErrors = [];
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();
            foreach ($errorMessages as $key => $message) {
                $index                 = (int)str_replace('file_content.', '', $key);
                $contentErrors[$index] = $message[0];
            }
        }

        return back()->withInput()
            ->with([
                'content_errors' => $contentErrors,
                'file_content'   => $fileContents
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $accountId
     * @return Factory|RedirectResponse|Response|Redirector|View
     */
    public function edit($accountId)
    {
        // Validate request parameters
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))->withErrors($validator)->withInput();
        }
        // Get data info
        $account     = Account::find($accountId);
        $restrictIps = [];
        foreach ($account->restricts->toArray() as $restrict) {
            if ($restrict['type'] === RESTRICT_TYPE_IP) {
                $restrictIps[] = $restrict['value'];
            }
        }
        $account['restrict_ips'] = $restrictIps;
        $corporations            = Corporation::all();

        // Response
        return view('account.create', [
            'account'      => $account,
            'corporations' => $corporations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $accountId
     * @return RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $accountId)
    {
        // Validate account_id
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getEditRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Validate request parameters
        $validator = Validator::make($request->all(), ValidateAccountHelper::getUpdateRules($accountId), [],
            trans('tool/accounts.attributes'));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password'));
        }

        $account = $this->accountLogic->update($accountId, $request->all());
        if ($account === false) {
            // Store Account Error
            return back()->with('error_message',
                trans('tool/accounts.message.error_update'))->withInput($request->except('password'));
        }
        return redirect(route('account.edit', $accountId))
            ->with('success_message', trans('tool/accounts.message.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $accountId
     * @return RedirectResponse|Response|Redirector
     */
    public function destroy($accountId)
    {
        $validator = Validator::make(['account_id' => $accountId], ValidateAccountHelper::getDeleteRules());
        if ($validator->fails()) {
            return redirect(session(SESSION_ACCOUNT_INDEX_URL))->withErrors($validator)->withInput();
        }

        // Delete account
        if ($this->accountLogic->destroy($accountId) === false) {
            return back()->with('error_message', trans('tool/accounts.message.error_delete'));
        }
        return back()->with('success_message', trans('tool/accounts.message.success_delete'));
    }
}
