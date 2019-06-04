<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\PaymentCompany;
use App\Models\Provider;
use App\Models\User;
use Route;
use App\Http\Controllers\Admin\Controller as BaseController;
use App\Traits\AdminUser\AdminUserPages;
use App\Http\Response\ResourceResponse;
use App\Traits\Theme\ThemeAndViews;
use App\Traits\AdminUser\RoutesAndGuards;

class ResourceController extends BaseController
{
    use AdminUserPages,ThemeAndViews,RoutesAndGuards;

    public function __construct()
    {
        parent::__construct();
        if (!empty(app('auth')->getDefaultDriver())) {
            $this->middleware('auth:' . app('auth')->getDefaultDriver());
           // $this->middleware('role:' . $this->getGuardRoute());
            $this->middleware('permission:' .Route::currentRouteName());
            $this->middleware('active');
        }
        $this->response = app(ResourceResponse::class);
        $this->setTheme();
    }
    /**
     * Show dashboard for each user.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $payment_company_count = PaymentCompany::count();
        $provider_count = Provider::count();
        $user_count = User::count();
        $order_count = Order::count();
        $pass_order_count = Order::where('status','pass')->count();
        $return_order_count = Order::where('status','return')->count();
        $today_finish_order_count = Order::whereIn('status',['finish','pass'])->where('created_at','>=',date('Y-m-d 00:00:00'))->count();

        return $this->response->title(trans('app.admin.panel'))
            ->view('home')
            ->data(compact('payment_company_count','provider_count','user_count','order_count','pass_order_count','return_order_count','today_finish_order_count'))
            ->output();
    }
    public function dashboard()
    {
        return $this->response->title('测试')
            ->view('dashboard')
            ->output();
    }
}
