# Laravel5.2-AdminLTE-RBAC
#### 说明
- 一个基于Laravel5.2 和 [zizaco/entrust](https://github.com/Zizaco/entrust "zizaco/entrust"),结合AdminLTE的简易后台,已完成权限控制,便于二次扩展

#### 安装步骤
- **clone**代码到本地, `git clone git@github.com:forgottener/Laravel5.2-AdminLTE-RBAC`

- 项目目录下执行 `composer install`

- 由于zizaco/entrust项目目前版本("zizaco/entrust": "dev-master")的代码有点bug(没有考虑到表自定义命名的问题,引起了无法找到外键),所以composer安装后需要手动修改该扩展代码,位置在:vendor/zizaco/entrust/src/Entrust/Traits/EntrustPermissionTrait.php:20行
> ```
    public function roles()
        {
            //return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.permission_role_table'));
            return $this->belongsToMany(Config::get('entrust.role'), Config::get('entrust.permission_role_table'), Config::get('entrust.permission_foreign_key'), Config::get('entrust.role_foreign_key'));
        }
      ```
    
-  `database/seeds/rbac.sql` 执行文件的sql,导入初始数据到你的mysql中

- 配置 `.env` 文件,选择填入local 或者 dev 或者 production即可 (便于切换环境,配置读取相应的.local.env, .dev.env, .production.env)

- 执行 `php artisan key`

- 项目目录下执行 `php artisan serve` 使用 `http://localhost:8000/admin/index`登录后台

- 默认后台账号: `admin@admin.com` 密码 : `123456`, `test@test.com` 密码 : '123456'


