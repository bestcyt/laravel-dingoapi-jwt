<?php

namespace App\Console\Commands\b;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class initBPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bPermission:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化b系统的角色权限';

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
        //离职权限
        $dismiss_see = Permission::create(['guard_name' => 'b-api', 'name' => 'b_dismiss_see']);
        $dismiss_edit = Permission::create(['guard_name' => 'b-api', 'name' => 'b_dismiss_edit']);
        //申请加入权限
        $join_see = Permission::create(['guard_name' => 'b-api', 'name' => 'b_join_see']);
        $join_edit = Permission::create(['guard_name' => 'b-api', 'name' => 'b_join_edit']);
        //小程序权限
        $app_see = Permission::create(['guard_name' => 'b-api', 'name' => 'b_app_see']);
        $app_edit = Permission::create(['guard_name' => 'b-api', 'name' => 'b_app_edit']);

        $b_employee = Role::create(['guard_name' => 'b-api', 'name' => 'b_employee']);
        $b_team_admin = Role::create(['guard_name' => 'b-api', 'name' => 'b_team_admin']);
        $b_super_admin = Role::create(['guard_name' => 'b-api', 'name' => 'b_super_admin']);

        $b_employee->givePermissionTo([$app_see,$app_edit]);
        $b_team_admin->givePermissionTo([$dismiss_see,$join_see,$app_see]);
        $b_super_admin->givePermissionTo([$dismiss_see,$dismiss_edit,$join_see,$join_edit,$app_see,$app_edit]);

    }
}
