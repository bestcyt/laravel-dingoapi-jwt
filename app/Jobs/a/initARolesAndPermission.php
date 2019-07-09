<?php

namespace App\Jobs\a;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class initARolesAndPermission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
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

        $app_edit = Permission::create(['guard_name' => 'a-api', 'name' => 'a_app_edit']);

        $a_employee = Role::create(['guard_name' => 'a-api', 'name' => 'a_employee']);   //普通员工
        $a_team_admin = Role::create(['guard_name' => 'a-api', 'name' => 'a_team_admin']);//
        $a_super_admin = Role::create(['guard_name' => 'a-api', 'name' => 'a_super_admin']);

        $a_employee->revokePermissionTo([]);
        $a_employee->givePermissionTo([$app_see,$app_edit]);
        $a_team_admin->givePermissionTo([$employee_see,$role_see,$position_see]);
        $a_super_admin->givePermissionTo([$employee_see,$employee_edit,$role_see,$role_edit,
            $position_see,$position_edit,$app_see,$app_edit]);
    }
}
