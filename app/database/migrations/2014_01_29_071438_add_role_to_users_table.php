<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRoleToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('role_id')->unsigned()
					->nullable()
					->default(null)
					->after('password');
			
			$table->foreign('role_id')
					->references('id')->on('acl_roles')
					->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('users_role_id_foreign');
			$table->dropColumn('role_id');
		});
	}

}