<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bRoles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('companyId')->comment('b系统不同公司id');
            $table->integer('roleId')->comment('b系统不同公司roleid，默认初始化4个，1总监，2团长3队长4队员');;
            $table->integer('name')->comment('角色名称');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bRoles');
    }
}
