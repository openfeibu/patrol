

<div class="login layui-anim layui-anim-up">
	<div class="login-con">
		<div class="login-con-title">海带巡检管理后台--支付商</div>
		{!! Theme::partial('message') !!}
		{!!Form::vertical_open()->id('login')->method('POST')->class('layui-form')->action(guard_url('login')) !!}
			<div class="form-title">
				<div class="form-title-item">账号密码登陆</div>
			</div>
			<input name="phone" placeholder="账号（手机号码）"  type="text" lay-verify="required" class="layui-input" >
			<input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
			
			<input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit" class="login_btn">
			<input id="rememberme" type="hidden" name="rememberme" value="1">
		{!!Form::Close()!!}
	</div>
</div>
