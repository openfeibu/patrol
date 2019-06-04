<?php

namespace App\Http\Controllers\Payment;

use App\Models\Order;
use App\Models\PaymentCompany;
use App\Models\Provider;
use App\Models\User;
use Route,Auth;
use App\Http\Controllers\Payment\Controller as BaseController;
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
        $payment_company_id = Auth::user()->payment_company_id;
        $order_count = Order::where('payment_company_id',$payment_company_id)->count();
        $pass_order_count = Order::where('payment_company_id',$payment_company_id)->where('status','pass')->count();
        $return_order_count = Order::where('payment_company_id',$payment_company_id)->where('status','return')->count();
        $today_finish_order_count = Order::where('payment_company_id',$payment_company_id)->whereIn('status',['finish','pass'])->where('created_at','>=',date('Y-m-d 00:00:00'))->count();

        return $this->response->title(trans('app.admin.panel'))
            ->view('home')
            ->data(compact('order_count','pass_order_count','return_order_count','today_finish_order_count'))
            ->output();
    }
    public function dashboard()
    {
        return $this->response->title('测试')
            ->view('dashboard')
            ->output();
    }
}
