<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePortsFdbTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ports_fdb', function(Blueprint $table)
		{
			$table->bigInteger('ports_fdb_id', true)->unsigned();
			$table->integer('port_id')->unsigned()->index();
			$table->string('mac_address', 32)->index('mac_address');
			$table->integer('vlan_id')->unsigned()->index();
			$table->integer('device_id')->unsigned()->index();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ports_fdb');
	}

}
