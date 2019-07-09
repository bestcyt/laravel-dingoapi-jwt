<?php

namespace App\Jobs\b;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class initBRolesAndPermission implements ShouldQueue
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
