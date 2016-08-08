@section('css')
    {{--icheck--}}
    <link href="{{ asset("/bower_components/AdminLTE/plugins/iCheck/square/blue.css") }}" rel="stylesheet">
@stop

<div class="form-group">
    <label for="" class="col-md-3 control-label">角色名称</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="" class="col-md-3 control-label">角色标签</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="display_name" value="{{ $display_name }}" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-md-3 control-label">角色概述</label>
    <div class="col-md-5">
        <textarea name="description" class="form-control" rows="3">{{ $description }}</textarea>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-md-3 control-label">权限列表</label>
</div>
<div class="panel panel-default">
    @if($permissionAll)
        @foreach($permissionAll as $v)
            <div class="top-permission col-md-12">
                <a href="javascript:;" class="display-sub-permission-toggle">
                    <span class="glyphicon glyphicon-minus"></span>
                </a>
                <label>
                    <input type="checkbox" name="permissions[]" value="{{ $v['id'] }}" class="top-permission-checkbox" {{ in_array($v['id'], $perms) ? "checked" : "" }}>
                    &nbsp;&nbsp;{{ $v['display_name'] }}
                </label>
            </div>

            <div class="sub-permissions col-md-11 col-md-offset-1" style="display: block;">
                @if(isset($v['_child']) && !empty($v['_child']))
                    @foreach($v['_child'] as $vv)
                        <div class="col-sm-3">
                            <label><input type="checkbox" name="permissions[]" value="{{ $vv['id'] }}" class="sub-permission-checkbox" {{ in_array($vv['id'], $perms) ? "checked" : "" }} >&nbsp;&nbsp;{{ $vv['display_name'] }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    @endif
</div>

@section('js')
    <!-- iCheck -->
    <script src="{{ asset("/bower_components/AdminLTE/plugins/iCheck/icheck.min.js") }}"></script>
    <script>
        $(document).ready(function(){
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });

            $(".top-permission-checkbox").on('ifChecked ifUnchecked', function(event) {
                if (event.type == 'ifChecked') {
                    $childCheck = $(this).parents('.top-permission').next('.sub-permissions').find('input');
                    var isCheck = 0;
                    $childCheck.each(function() {
                        if (true == $(this).is(':checked')) {
                            isCheck = 1;
                            return false;
                        }
                    })
                    if (isCheck == 0) {
                        $(this).parents('.top-permission').next('.sub-permissions').find('input').iCheck('check');
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $(this).parents('.top-permission').next('.sub-permissions').find('input').iCheck('uncheck');
                }
            });

            $(".sub-permission-checkbox").on('ifChecked ifUnchecked', function(event){
                if (event.type == 'ifChecked') {
                    $(this).parents('.sub-permissions').prev('.top-permission').find('.top-permission-checkbox').iCheck('check');
                }
            })
        });
    </script>
@stop
