<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntityStateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entityState', function(Blueprint $table)
		{
			$table->integer('entity_state_id', true);
			$table->integer('device_id')->nullable()->index();
			$table->integer('entPhysical_id')->nullable();
			$table->dateTime('entStateLastChanged')->nullable();
			$table->integer('entStateAdmin')->nullable();
			$table->integer('entStateOper')->nullable();
			$table->integer('entStateUsage')->nullable();
			$table->text('entStateAlarm', 65535)->nullable();
			$table->integer('entStateStandby')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entityState');
	}

}
