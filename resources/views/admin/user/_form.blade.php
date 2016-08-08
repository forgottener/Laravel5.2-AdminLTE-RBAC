@section('css')
    {{--icheck--}}
    <link href="{{ asset("/bower_components/AdminLTE/plugins/iCheck/square/blue.css") }}" rel="stylesheet">
@stop

<div class="form-group">
    <label for="" class="col-md-3 control-label">用户名</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="name" value="{{ $name }}" autofocus>
    </div>
</div>
<div class="form-group">
    <label for="" class="col-md-3 control-label">邮箱</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="email" value="{{ $email }}" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-md-3 control-label">密码</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="password" value="" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="" class="col-md-3 control-label">密码确认</label>
    <div class="col-md-5">
        <input type="password" class="form-control" name="repassword" value="" autofocus>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">是否为超级管理员</label>
    <div class="col-md-5">
        <select class="form-control" name="is_super">
            <option value="0" @if($is_super == 0 )selected @endif >否</option>
            <option value="1" @if($is_super == 1 )selected @endif >是</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="tag" class="col-md-3 control-label">角色列表</label>
    <div class="col-md-6">
        @foreach($rolesAll as $v)
            <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
            <span class="checkbox-custom checkbox-default">
                <i class="fa"></i>
                    <input class="form-actions"
                           @if(in_array($v['id'],$roles))
                           checked
                           @endif
                           type="Checkbox" value="{{$v['id']}}"
                           name="roles[]"> <label for="">
                    {{$v['display_name']}}
                </label>
            </span>
            </div>
        @endforeach
    </div>
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
        });
    </script>
@stop

