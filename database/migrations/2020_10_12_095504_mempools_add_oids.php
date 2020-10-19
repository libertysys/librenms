<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MempoolsAddOids extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mempools', function (Blueprint $table) {
            $table->dropColumn('hrDeviceIndex');
            $table->string('mempool_perc_oid')->after('mempool_perc')->nullable();
            $table->string('mempool_used_oid')->after('mempool_used')->nullable();
            $table->string('mempool_free_oid')->after('mempool_free')->nullable();
            $table->string('mempool_total_oid')->after('mempool_total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mempools', function (Blueprint $table) {
            $table->integer('hrDeviceIndex')->nullable()->after('entPhysicalIndex');
            $table->dropColumn(['mempool_perc_oid', 'mempool_used_oid', 'mempool_free_oid', 'mempool_total_oid']);
        });
    }
}