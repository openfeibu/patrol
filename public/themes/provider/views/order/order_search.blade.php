<div class="layui-inline">
    <label class="layui-form-label">{{ trans("payment_company.name") }}：</label>
    <select name="payment_company_id" class="search_key layui-select" lay-verify="">
        <option value="0">全部</option>
        @foreach($payment_companies as $key => $payment_company)
            <option value="{{ $payment_company->id }}" @if($payment_company->id == $payment_company_id) selected @endif>{{ $payment_company->name }}</option>
        @endforeach
    </select>
</div>

<div class="layui-inline">
    <input class="layui-input layui-input-inline search_key" name="search_province" id="demoReload" placeholder="省份" autocomplete="off" value="{{ $search_province }}">
</div>

<div class="layui-inline">
    <input class="layui-input layui-input-inline search_key" name="search_city" id="demoReload" placeholder="城市" autocomplete="off" value="{{ $search_city }}">
</div>

<div class="layui-inline">
    <input class="layui-input layui-input-inline search_key" name="search_address" id="demoReload" placeholder="地址" autocomplete="off" value="{{ $search_address }}">
</div>

<div class="layui-inline">
    <input class="layui-input layui-input-inline search_key" name="search_merchant_name" id="demoReload" placeholder="商户名" autocomplete="off" value="{{ $search_merchant_name }}">
</div>

<button class="layui-btn" data-type="reload">搜索</button>