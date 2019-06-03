<div class="main">
    <div class="main_full">
        <div class="layui-col-md12">
            <div class="layui-card mt20" >
                <!-- <div class="layui-card-header">待办事项</div> -->
                <div class="layui-card-body">

                    <div class="fb-carousel fb-backlog " lay-anim="" lay-indicator="inside" lay-arrow="none" >
                        <div carousel-item="">
                            <ul class="layui-row fb-clearfix dataBox layui-col-space5">
                                <li class="layui-col-xs3">
                                    @permission(home())
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检员总数</h3>
                                        <p><cite>66</cite></p>
                                    </a>
                                    @endpermission
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检任务总数</h3>
                                        <p><cite>12</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检完成总数</h3>
                                        <p><cite>99</cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>巡检退单总数</h3>
                                        <p><cite>20</cite></p>
                                    </a>
                                </li>
								<li class="layui-col-xs3">
                                    <a lay-href="" class="fb-backlog-body">
                                        <h3>当日巡检总数</h3>
                                        <p><cite>20</cite></p>
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