<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentUserRequest;
use App\Models\PaymentUser;
use App\Models\PaymentCompany;
use App\Repositories\Eloquent\PaymentPermissionRepositoryInterface;
use App\Repositories\Eloquent\PaymentRoleRepositoryInterface;
use App\Repositories\Eloquent\PaymentUserRepositoryInterface;

/**
 * Resource controller class for user.
 */
class PaymentUserResourceController extends BaseController
{

    /**
     * @var Permissions
     */
    protected $permission;

    /**
     * @var roles
     */
    protected $roles;

    /**
     * Initialize payment_user resource controller.
     *
     * @param type PaymentUserRepositoryInterface $payment_user
     * @param type PaymentPermissionRepositoryInterface $permissions
     * @param type PaymentRoleRepositoryInterface $roles
     */

    public function __construct(
        PaymentUserRepositoryInterface $payment_user,
        PaymentPermissionRepositoryInterface $permissions,
        PaymentRoleRepositoryInterface $roles
    )
    {
        parent::__construct();
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->repository = $payment_user;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request)
    {
        $limit = $request->input('limit',config('app.limit'));
        $search = $request->input('search',[]);
        $search_name = isset($search['search_name']) ? $search['search_name'] : '';
        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\PaymentUserPresenter::class);

            if(!empty($search_name))
            {
                $data = $data->where(function ($query,$search_name){
                    $query->where('email','like','%'.$search_name.'%')->orWhere('phone','like','%'.$search_name.'%')->orWhere('name','like','%'.$search_name.'%');
                });
            }
            $data = $data->orderBy('id','desc')
                ->getDataTable($limit);
            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();
        }
        return $this->response->title(trans('app.admin.panel'))
            ->view('payment_user.index')
            ->output();
    }

    public function show(Request $request,PaymentUser $payment_user)
    {
        if ($payment_user->exists) {
            $view = 'payment_user.show';
        } else {
            $view = 'payment_user.new';
        }
        $roles = $this->roles->all();

        $payment_companies = PaymentCompany::orderBy('id','desc')->get();

        return $this->response->title(trans('app.view') . ' ' . trans('payment_user.name'))
            ->data(compact('payment_user','roles','payment_companies'))
            ->view($view)
            ->output();
    }

    /**
     * Show the form for creating a new user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request)
    {

        $payment_user = $this->repository->newInstance([]);
        $roles       = $this->roles->all();
        $payment_companies = PaymentCompany::orderBy('id','desc')->get();

        return $this->response->title(trans('app.new') . ' ' . trans('payment_user.name'))
            ->view('payment_user.create')
            ->data(compact('payment_user', 'roles','payment_companies'))
            ->output();
    }

    /**
     * Create new user.
     *
     * @param PaymentUserRequest $request
     *
     * @return Response
     */
    public function store(PaymentUserRequest $request)
    {
        try {
            $attributes              = $request->all();
            $roles          = $request->get('roles');
            $attributes['api_token'] = str_random(60);

            $payment_user = $this->repository->create($attributes);
            $payment_user->roles()->sync($roles);
            return $this->response->message(trans('messages.success.created', ['Module' => trans('payment_user.name')]))
                ->code(204)
                ->status('success')
                ->url(guard_url('payment_user'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('payment_user'))
                ->redirect();
        }

    }

    /**
     * Update the user.
     *
     * @param Request $request
     * @param PaymentUser   $payment_user
     *
     * @return Response
     */
    public function update(Request $request, PaymentUser $payment_user)
    {
        try {
            $attributes = $request->all();
            $roles          = $request->get('roles');
            $payment_user->update($attributes);
            $payment_user->roles()->sync($roles);
            return $this->response->message(trans('messages.success.updated', ['Module' => trans('payment_user.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('payment_user/' . $payment_user->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('payment_user/' . $payment_user->id))
                ->redirect();
        }
    }

    /**
     * @param Request $request
     * @param PaymentUser $payment_user
     * @return mixed
     */
    public function destroy(Request $request, PaymentUser $payment_user)
    {
        try {

            $payment_user->forceDelete();
            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('payment_user.name')]))
                ->code(202)
                ->status('success')
                ->url(guard_url('payment_user'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('payment_user'))
                ->redirect();
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('payment_user.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('payment_user'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('payment_user'))
                ->redirect();
        }
    }
}