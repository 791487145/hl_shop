<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auth_menu', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 40)->comment('菜单路由');
			$table->integer('parent_id')->nullable()->default(0);
			$table->boolean('status')->nullable()->default(1)->comment('状态1：正常');
			$table->string('title', 20)->nullable()->comment('菜单名');
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
		Schema::drop('auth_menu');
	}

}
