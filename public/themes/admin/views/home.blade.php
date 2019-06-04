<div class="main">
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="layui-card mt20">
                <!-- <div class="layui-card-header">待办事项</div> -->
                <div class="layui-card-body">

                    <div class="fb-carousel fb-backlog " lay-anim="" lay-indicator="inside" lay-arrow="none" >
                        <div carousel-item="">
                            <ul class="layui-row fb-clearfix dataBox layui-col-space5">
                                <li class="layui-col-xs3 ">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>支付商总数</h3>
                                        <p><cite>{{ $payment_company_count }}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>服务商总数</h3>
                                        <p><cite>{{ $provider_count }}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检人员总数</h3>
                                        <p><cite>{{ $user_count }}</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检任务总数</h3>
                                        <p><cite>{{ $order_count }}</cite></p>
                                    </a>
                                </li>
								<li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>已审核任务总数</h3>
                                        <p><cite>{{ $pass_order_count }}</cite></p>
                                    </a>
                                </li>
								<li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>退单任务总数</h3>
                                        <p><cite>{{ $return_order_count }}</cite></p>
                                    </a>
                                </li>
								<li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>当天完成巡检任务总数</h3>
                                        <p><cite>{{ $today_finish_order_count }}</cite></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>