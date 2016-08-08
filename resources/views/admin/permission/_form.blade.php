<div class="form-group">
    <label for="tag" class="col-md-3 control-label">权限规则</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="name" value="{{ $name }}" autofocus>
        <input type="hidden" class="form-control" name="fid" value="{{ $fid }}" autofocus>
    </div>
    <div class="col-md-3">(顶级菜单有下级请以#为开头,示例:#system)</div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">权限名称</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="display_name" value="{{ $display_name }}" autofocus>
    </div>
</div>
@if($fid == 0 )
{{--图标修改--}}
    <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-iconpicker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css")}}"/>
    <link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css")}}"/>

    <div class="form-group">
    <label for="tag" class="col-md-3 control-label">图标</label>
    <div class="col-md-6">
        <!-- Button tag -->
        <button class="btn btn-default" name="icon" data-iconset="fontawesome" data-icon="{{ $icon?$icon:'fa-sliders' }}" role="iconpicker"></button>
    </div>

    </div>
@section('js')

    <script type="text/javascript" src="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js")}}"></script>
    <script type="text/javascript" src="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.js")}}"></script>

@stop
@endif
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">权限概述</label>
    <div class="col-md-6">
        <textarea name="description" class="form-control" rows="3">{{ $description }}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">是否为菜单</label>
    <div class="col-md-6">
        <select class="form-control" name="is_menu">
            <option value="0" @if($is_menu == 0 )selected @endif >否</option>
            <option value="1" @if($is_menu == 1 )selected @endif >是</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-md-3 control-label">排序</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="sort" value="{{ $sort }}" autofocus>
    </div>
</div>

