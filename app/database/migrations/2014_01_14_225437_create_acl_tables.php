<?php

use Illuminate\Database\Migrations\Migration;

class CreateAclTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Creates the acl_resources table
        Schema::create('acl_resources', function($table)
        {
            $table->increments('id');
			$table->string('name');
			$table->enum('type', array('action', 'closure', 'other'))->default('other');
			$table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
			
			$table->unique('name');
			$table->foreign('parent_id')
					->references('id')->on('acl_resources')
					->onDelete('cascade');
        });
		
		// Create the acl_roles table
		Schema::create('acl_roles', function($table) 
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
			
			$table->unique('name');
		});
		
		// Create the acl_role_parents table
		Schema::create('acl_role_parents', function($table) 
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned();
			$table->integer('parent_id')->unsigned();
			$table->integer('order_num')->default(0);
			
			$table->foreign('role_id')
					->references('id')->on('acl_roles')
					->onDelete('cascade');
			$table->foreign('parent_id')
					->references('id')->on('acl_roles')
					->onDelete('cascade');
		});
		
		// Create the acl_rules table
		Schema::create('acl_rules', function($table)
		{
			$table->increments('id');
			$table->integer('role_id')->unsigned();
			$table->integer('resource_id')->unsigned();
			$table->enum('access', array('allow', 'deny'))->default('deny');
			$table->string('privilege');
			
			$table->foreign('role_id')
					->references('id')->on('acl_roles')
					->onDelete('cascade');
			$table->foreign('resource_id')
					->references('id')->on('acl_resources')
					->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('acl_rules', function($table)
		{
			$table->dropForeign('acl_rules_role_id_foreign');
			$table->dropForeign('acl_rules_resource_id_foreign');
		});
		Schema::drop('acl_rules');
		Schema::table('acl_role_parents', function($table)
		{
			$table->dropForeign('acl_role_parents_role_id_foreign');
			$table->dropForeign('acl_role_parents_parent_id_foreign');
		});
		Schema::drop('acl_role_parents');
		Schema::drop('acl_roles');
		Schema::table('acl_resources', function($table) 
		{
			$table->dropForeign('acl_resources_parent_id_foreign');
		});
		Schema::drop('acl_resources');
	}

}