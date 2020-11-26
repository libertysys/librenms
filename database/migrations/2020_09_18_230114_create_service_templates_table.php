<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('device_group_id')->index();
            $table->text('ip')->nullable()->default(null);
            $table->string('type');
            $table->string('stype', 20)->default('');
            $table->text('desc')->nullable()->default(null);
            $table->text('param')->nullable()->default(null);
            $table->boolean('ignore')->default(0);
            if (\LibreNMS\DB\Eloquent::getDriver() == 'mysql') {
                $table->timestamp('changed')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            } else {
                $table->timestamp('changed')->useCurrent();
            }
            $table->boolean('disabled')->default(0);
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_templates');
    }
}
