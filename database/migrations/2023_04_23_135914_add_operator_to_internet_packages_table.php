<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_packages', function (Blueprint $table) {
            $table->enum('operator', ['mtn', 'mci', 'rightel'])->after('traffic_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internet_packages', function (Blueprint $table) {
            $table->dropColumn('operator');
        });
    }
};
