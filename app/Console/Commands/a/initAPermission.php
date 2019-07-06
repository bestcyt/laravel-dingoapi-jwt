<?php

namespace App\Console\Commands\a;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class initAPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aPermission:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建a系统的所有初始化命令';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 创建a系统的所有命令和角色关联
        //人员权限
        $employee_see = Permission::create(['guard_name' => 'a-api', 'name' => 'a_employee_see']);
        $employee_edit = Permission::create(['guard_name' => 'a-api', 'name' => 'a_employee_edit']);
        //角色权限
        $role_see = Permission::create(['guard_name' => 'a-api', 'name' => 'a_role_see']);
        $role_edit = Permission::create(['guard_name' => 'a-api', 'name' => 'a_role_edit']);
        //职位权限
        $position_see = Permission::create(['guard_name' => 'a-api', 'name' => 'a_position_see']);
        $position_edit = Permission::create(['guard_name' => 'a-api', 'name' => 'a_position_edit']);

        //小程序权限
        $app_see = Permission::create(['guard_name' => 'a-api', 'name' => 'a_app_see']);
        $app_edit = Permission::create(['guard_name' => 'a-api', 'name' => 'a_app_edit']);


        $a_employee = Role::create(['guard_name' => 'a-api', 'name' => 'a_employee']);   //普通员工
        $a_team_admin = Role::create(['guard_name' => 'a-api', 'name' => 'a_team_admin']);//
        $a_super_admin = Role::create(['guard_name' => 'a-api', 'name' => 'a_super_admin']);

        $a_employee->givePermissionTo([$app_see,$app_edit]);
        $a_team_admin->givePermissionTo([$employee_see,$role_see,$position_see]);
        $a_super_admin->givePermissionTo([$employee_see,$employee_edit,$role_see,$role_edit,
            $position_see,$position_edit,$app_see,$app_edit]);


    }
}
