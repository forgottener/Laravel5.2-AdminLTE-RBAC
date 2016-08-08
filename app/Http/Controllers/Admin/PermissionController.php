<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminPermission as Permission;
use Cache,Event;

class PermissionController extends Controller
{
    protected $fields = [
        'fid' => 0,
        'icon'=>'',
        'name' => '',
        'display_name' => '',
        'description' => '',
        'is_menu' => 0,
        'sort' => 0,
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $fid = 0)
    {
        $fid = (int)$fid;
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $fid = $request->get('fid', 0);
            $data['recordsTotal'] = Permission::where('fid', $fid)->count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Permission::where('fid', $fid)->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Permission::where('fid', $fid)->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = Permission::where('fid', $fid)->
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }

        $datas['fid'] = $fid;
        if ($fid > 0) {
            $datas['data'] = Permission::find($fid);
        }
        return view('admin.permission.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fid)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['fid'] = $fid;
        return view('admin.permission.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PremissionCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Permission $permission, Request $request)
    {
        $this->validate($request, [
            'name'=>'required|unique:admin_permissions|max:255',
            'display_name'=>'required|max:255',
            'fid'=>'required|int',
            'is_menu'=>'required|int',
            'sort'=>'required|int',
        ]);
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field);
        }
        $permission->save();
        //Event::fire($perm);
        return redirect('/admin/permission/' . $permission->fid)->withSuccess('添加成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find((int)$id);
        if (!$permission) return redirect('/admin/permission')->withErrors("找不到该权限!");
        $data = ['id' => (int)$id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $permission->$field);
        }
        return view('admin.permission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdateRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|unique:admin_permissions,name,'.$request->get('id').'|max:255',
            'display_name'=>'required|unique:admin_permissions,display_name,'.$request->get('id').'|max:255',
            'fid'=>'int',
            'is_menu'=>'int',
            'sort'=>'int',
        ]);
        $permission = Permission::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field);
        }
        $permission->save();
        //Event::fire(new permChangeEvent());
        return redirect('admin/permission/' . $permission->fid)->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $child = Permission::where('fid', $id)->first();

        if ($child) {
            return redirect()->back()
                ->withErrors("请先将该权限的子权限删除后再做删除操作!");
        }
        $tag = Permission::find((int)$id);
        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }
        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
