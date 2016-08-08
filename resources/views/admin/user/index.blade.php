@extends('admin.layouts.base')

@section('title','用户列表')

@section('pageHeader','用户管理')

@section('pageDesc','用户管理页面')

@section('content')

    <div class="row page-title-row" style="margin:5px;">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ url('admin/user/create') }}" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i> 添加用户
            </a>
        </div>
    </div>
    <div class="row page-title-row" style="margin:5px;">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
        </div>
    </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                    @include('admin.partials.errors')
                    @include('admin.partials.success')
                    <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th data-sortable="false" class="hidden-sm"></th>
                            <th class="hidden-sm">用户名</th>
                            <th class="hidden-sm">邮箱</th>
                            <th class="hidden-md">角色创建日期</th>
                            <th class="hidden-md">角色修改日期</th>
                            <th class="hidden-sm">是否超管</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要删除这个用户吗?
                    </p>
                </div>
                <div class="modal-footer">
                    <form class="deleteForm" method="POST" action="{{ url('admin/user') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>确认
                        </button>
                    </form>
                </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            var table = $("#tags-table").DataTable({
                language: {
                    "processing": "处理中...",
                    "lengthMenu": "显示 _MENU_ 项结果",
                    "zeroRecords": "没有匹配结果",
                    "info": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "infoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "infoFiltered": "(由 _MAX_ 项结果过滤)",
                    "infoPostFix": "",
                    "search": "搜索:",
                    "url": "",
                    "emptyTable": "表中数据为空",
                    "loadingRecords": "载入中...",
                    "infoThousands": ",",
                    "paginate": {
                        "first": "首页",
                        "previous": "上页",
                        "next": "下页",
                        "last": "末页"
                    },
                    "aria": {
                        "sortAscending": ": 以升序排列此列",
                        "sortDescending": ": 以降序排列此列"
                    }
                },
                order: [[1, "desc"]],
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/user/index') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "created_at"},
                    {"data": "updated_at"},
                    {"data": "is_super"},
                    {"data": "action"}
                ],
                columnDefs: [
                    {
                        'targets': -1, "render": function (data, type, row) {
                            var caozuo = '<a style="margin:3px;" href="/admin/user/' + row['id'] + '/edit" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>';
                            if (row['id'] != 1) {
                                caozuo += '<a style="margin:3px;" href="#" attr="' + row['id'] + '" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>';
                            }
                            return caozuo;
                        }
                    },
                    {
                        "targets": -2, "render": function (data, type, row) {
                        if (data == 1) {
                            return '<span class=""><small class="label bg-green">是</small></span>';
                        } else {
                            return '<span class=""><small class="label bg-red">否</small></span>';
                        }
                    }
                    }
                ]
            });

            table.on('preXhr.dt', function () {
                loadShow();
            });

            table.on('draw.dt', function () {
                loadFadeOut();
            });

            table.on('order.dt search.dt', function () {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $("table").delegate('.delBtn', 'click', function () {
                var id = $(this).attr('attr');
                $('.deleteForm').attr('action', '/admin/user/' + id);
                $("#modal-delete").modal();
            });

        });
    </script>
@stop