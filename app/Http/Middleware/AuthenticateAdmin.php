<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin\AdminPermission;
use Route,URL,Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guard = $guard ? $guard : "admin";
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/login');
            }
        } else {
            if (Auth::guard($guard)->user()->is_super) {
                view()->share('menuData',$this->getMenu());
                return $next($request);
            }
            $previousUrl = URL::previous();
            if (!Auth::guard($guard)->user()->can(Route::currentRouteName())) {
                if($request->ajax() || $request->wantsJson()) {
                    return response('您没有权限执行此操作', 403);
                } else {
                    return response()->view('admin.errors.403', compact('previousUrl'));
                }
            }
            view()->share('menuData',$this->getMenu());
            return $next($request);
        }
    }

    /**
     * 获取左边菜单栏
     * @return array
     */
    function getMenu()
    {
        //查找出所有的菜单
        $table = AdminPermission::orderBy('fid', 'asc')->orderBy('sort', 'desc')->get()->toArray();
        $newData = [];
        $user = Auth::guard('admin')->user();

        $currentPermission = AdminPermission::where('name', Route::currentRouteName())->select('id', 'fid')->first();
        $permissionsList = array_column($table, 'fid', 'id');
        $newData['current'] = get_fathers_id($permissionsList, $currentPermission->id);
        $newData['current'][] = $currentPermission->id;

        $permissions = collect([]);
            $user->roles()->with('perms')->get()->pluck('perms')->map(function($item, $key) use (&$permissions){
                $child = $item->where('is_menu', 1)->pluck('id');
                if ($key == 0) {
                    $permissions = $child;
                } else {
                    $permissions = $permissions->merge($child);
                }
        });
        $permissions = array_unique($permissions->toArray());

        if (!empty($table)) {
            if (is_array($table)) {
                // 创建基于主键的数组引用
                $refer = array();
                foreach ($table as $key => $data) {
                    if ($user->is_super || in_array($data['id'], $permissions)) {
                        $refer[$data['id']] =& $table[$key];
                    }
                }
                unset($key, $data);
                foreach ($table as $key => $data) {
                    // 判断是否存在parent
                    $parentId =  $data['fid'];
                    if ($user->is_super || in_array($data['id'], $permissions)) {
                        if (0 == $parentId) {
                            $newData['menu'][] =& $table[$key];
                        } else {
                            if (isset($refer[$parentId])) {
                                $parent =& $refer[$parentId];
                                $parent['_child'][] =& $table[$key];
                            }
                        }
                    }
                }
            }
        }
        return $newData;
    }
}
