<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToMplsLspPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mpls_lsp_paths', function (Blueprint $table) {
            /** add
             * vRtrMplsLspPathTunnelARHopListIndex
             * vRtrMplsLspPathTunnelCHopListIndex
             * indexes to table
             */
            $table->unsignedInteger('mplsLspPathTunnelARHopListIndex')->nullable();
            $table->unsignedInteger('mplsLspPathTunnelCHopListIndex')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mpls_lsp_paths', function (Blueprint $table) {
            $table->dropColumn(['mplsLspPathTunnelARHopListIndex', 'mplsLspPathTunnelCHopListIndex']);
        });
    }
}
