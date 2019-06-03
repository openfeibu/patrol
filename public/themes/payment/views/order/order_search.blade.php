<br>
<div class="layui-inline mt10">
    <label class="layui-form-label">{{ trans("provider.name") }}：</label>
</div>

<div class="layui-inline mt10 layui-input-search">

    <select name="provider_id" class="search_key layui-select" lay-verify="">
        <option value="0">全部</option>
        @foreach($providers as $key => $provider)
            <option value="{{ $provider->id }}" @if($provider->id == $provider_id) selected @endif>{{ $provider->name }}</option>
        @endforeach
    </select>
</div>
<br>
<div class="layui-inline mt10">
    <input class="layui-input layui-input-inline search_key" name="search_province" id="demoReload" placeholder="省份" autocomplete="off" value="{{ $search_province }}">
</div>

<div class="layui-inline mt10">
    <input class="layui-input layui-input-inline search_key" name="search_city" id="demoReload" placeholder="城市" autocomplete="off" value="{{ $search_city }}">
</div>

<div class="layui-inline mt10">
    <input class="layui-input layui-input-inline search_key" name="search_address" id="demoReload" placeholder="地址" autocomplete="off" value="{{ $search_address }}">
</div>

<div class="layui-inline mt10">
    <input class="layui-input layui-input-inline search_key" name="search_merchant_name" id="demoReload" placeholder="商户名" autocomplete="off" value="{{ $search_merchant_name }}">
</div>

<button class="layui-btn mt10" data-type="reload">搜索</button>