<div class="main">
    <div class="layui-card fb-minNav">
        <div class="layui-breadcrumb" lay-filter="breadcrumb" style="visibility: visible;">
            <a href="{{ guard_url('home') }}">主页</a><span lay-separator="">/</span>
            <a><cite>添加{{ trans('merchant.name') }}</cite></a>
        </div>
    </div>
    <div class="main_full">
        <div class="layui-col-md12">
            {!! Theme::partial('message') !!}
            <div class="fb-main-table">
                <form class="layui-form" action="{{guard_url('merchant')}}" method="post" method="post" lay-filter="fb-form">
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.name') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" autocomplete="off" placeholder="请输入{{ trans('merchant.label.name') }}" class="layui-input" value="" lay-verify="required">
                        </div>
                        <div class="layui-form-mid layui-word-aux">* 必填</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.linkman') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="linkman" autocomplete="off" placeholder="请输入{{ trans('merchant.label.linkman') }}" class="layui-input" value="" lay-verify="required">
                        </div>
                        <div class="layui-form-mid layui-word-aux">* 必填</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.phone') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="phone" autocomplete="off" placeholder="请输入{{ trans('merchant.label.phone') }}" class="layui-input" value="" lay-verify="required">
                        </div>
                        <div class="layui-form-mid layui-word-aux">* 必填</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.merchant_sn') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="merchant_sn" autocomplete="off" placeholder="请输入{{ trans('merchant.label.merchant_sn') }}" class="layui-input" value=""  lay-verify="required">
                        </div>
                        <div class="layui-form-mid layui-word-aux">* 必填</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.model') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="model" autocomplete="off" placeholder="请输入{{ trans('merchant.label.model') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.pn') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="pn" autocomplete="off" placeholder="请输入{{ trans('merchant.label.pn') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.sn') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="sn" autocomplete="off" placeholder="请输入{{ trans('merchant.label.sn') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.address') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="address" autocomplete="off" placeholder="请输入{{ trans('merchant.label.address') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.province') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="province" autocomplete="off" placeholder="请输入{{ trans('merchant.label.province') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">{{ trans('merchant.label.city') }}</label>
                        <div class="layui-input-inline">
                            <input type="text" name="city" autocomplete="off" placeholder="请输入{{ trans('merchant.label.city') }}" class="layui-input" value="">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>
                    {!!Form::token()!!}
                </form>
            </div>

        </div>
    </div>
</div>
{!! Theme::asset()->container('ueditor')->scripts() !!}