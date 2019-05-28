<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Payment\ResourceController as BaseController;
use Auth,Validator;

use App\Models\ProviderUser;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\ProviderUserRequest;
use App\Repositories\Eloquent\ProviderPermissionRepositoryInterface;
use App\Repositories\Eloquent\ProviderRoleRepositoryInterface;
use App\Repositories\Eloquent\ProviderUserRepositoryInterface;

/**
 * Resource controller class for user.
 */
class ProviderUserResourceController extends BaseController
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
     * Initialize provider_user resource controller.
     *
     * @param type ProviderUserRepositoryInterface $provider_user
     * @param type ProviderPermissionRepositoryInterface $permissions
     * @param type ProviderRoleRepositoryInterface $roles
     */

    public function __construct(
        ProviderUserRepositoryInterface $provider_user,
        ProviderPermissionRepositoryInterface $permissions,
        ProviderRoleRepositoryInterface $roles
    )
    {
        parent::__construct();
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->repository = $provider_user;
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
                ->where(['payment_company_id' => Auth::user()->payment_company_id])
                ->setPresenter(\App\Repositories\Presenter\ProviderUserPresenter::class);
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
            ->view('provider_user.index')
            ->output();
    }

    public function show(Request $request,ProviderUser $provider_user)
    {
        if ($provider_user->exists) {
            $view = 'provider_user.show';
        } else {
            $view = 'provider_user.new';
        }
        $roles = $this->roles->all();
        $providers = Provider::where('payment_company_id',Auth::user()->payment_company_id)->orderBy('id','desc')->get();

        return $this->response->title(trans('app.view') . ' ' . trans('provider_user.name'))
            ->data(compact('provider_user','roles','providers'))
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
        $provider_user = $this->repository->newInstance([]);
        $roles       = $this->roles->all();
        $providers = Provider::where('payment_company_id',Auth::user()->payment_company_id)->orderBy('id','desc')->get();
        return $this->response->title(trans('app.new') . ' ' . trans('provider_user.name'))
            ->view('provider_user.create')
            ->data(compact('provider_user', 'roles','providers'))
            ->output();
    }

    /**
     * Create new user.
     *
     * @param ProviderUserRequest $request
     *
     * @return Response
     */
    public function store(ProviderUserRequest $request)
    {
        try {
            $attributes              = $request->all();

            $roles          = $request->get('roles');
            $attributes['api_token'] = str_random(60);
            $attributes['payment_company_id'] = Auth::user()->payment_company_id;
            $provider_user = $this->repository->create($attributes);
            $provider_user->roles()->sync($roles);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('provider_user.name')]))
                ->code(204)
                ->status('success')
                ->url(guard_url('provider_user'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('provider_user'))
                ->redirect();
        }

    }

    /**
     * Update the user.
     *
     * @param ProviderUserRequest $request
     * @param ProviderUser   $provider_user
     *
     * @return Response
     */
    public function update(ProviderUserRequest $request, ProviderUser $provider_user)
    {
        try {
            $attributes = $request->all();
            $roles          = $request->get('roles');
            $provider_user->update($attributes);
            $provider_user->roles()->sync($roles);
            return $this->response->message(trans('messages.success.updated', ['Module' => trans('provider_user.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('provider_user/' . $provider_user->id))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('provider_user/' . $provider_user->id))
                ->redirect();
        }
    }

    /**
     * @param ProviderUserRequest $request
     * @param ProviderUser $provider_user
     * @return mixed
     */
    public function destroy(ProviderUserRequest $request, ProviderUser $provider_user)
    {
        try {

            $provider_user->forceDelete();
            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('provider_user.name')]))
                ->code(202)
                ->status('success')
                ->url(guard_url('provider_user'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('provider_user'))
                ->redirect();
        }

    }

    /**
     * @param ProviderUserRequest $request
     * @return mixed
     */
    public function destroyAll(ProviderUserRequest $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('provider_user.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('provider_user'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('provider_user'))
                ->redirect();
        }
    }
}