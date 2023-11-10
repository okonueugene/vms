<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visiting_details', function (Blueprint $table) {
            //
            $table->string('vehicle_registration_no')->after('purpose')->nullable();
            $table->string('belongings')->after('vehicle_registration_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visiting_details', function (Blueprint $table) {
            //
            $table->dropColumn('vehicle_registration_no');
            $table->dropColumn('belongings');
        });
    }
};