<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AdminPermission as Permission;
use App\Models\Admin\AdminRole as Role;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
        'perms' => [],
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = Role::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = $data['recordsTotal'];
                $data['data'] = Role::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $perms = Permission::all()->toArray();
        $data['permissionAll'] = list_to_tree($perms);
        return view('admin.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PremissionCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'=>'required|unique:admin_roles|max:255',
            'display_name'=>'required|max:255'
        ]);
       foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        unset($role->perms);
        $role->save();
        if (is_array($request->get('permissions'))) {
            $role->attachPermissions($request->get('permissions'));
        }
        return redirect('/admin/role')->withSuccess('添加成功！');
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
        $role = Role::find((int)$id);
        if (!$role) return redirect('/admin/role')->withErrors("找不到该角色!");
        $permissions = [];
        if ($role->perms) {
            foreach ($role->perms as $v) {
                $permissions[] = $v->id;
            }
        }
        $role->perms = $permissions;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $role->$field);
        }
        $perms = Permission::all()->toArray();
        $data['permissionAll'] = list_to_tree($perms);
        $data['id'] = (int) $id;
        return view('admin.role.edit', $data);
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
            'name'=>'required|unique:admin_roles,name,'.$request->get('id').'|max:255',
            'display_name'=>'required|unique:admin_roles,display_name,'.$request->get('id').'|max:255'
        ]);
        $role = Role::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        $oldPerms = $role->perms;
        unset($role->perms);
        $role->save();
        $role->detachPermissions($oldPerms);
        if (is_array($request->get('permissions'))) {
            $role->attachPermissions($request->get('permissions'));
        }
        return redirect('/admin/role')->withSuccess('修改成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find((int)$id);
        if ($role) {
            $role->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }

        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
