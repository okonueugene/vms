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
        Schema::create('casuals', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('phone');
            $table->string('designation')->nullable();
            $table->enum('gender', ['male','female','other']);
            $table->string('official_identification_number', 255);
            $table->date('date_of_joining')->nullable();
            $table->enum('status', ['active','inactive']);
            $table->string('about')->nullable();

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
        Schema::dropIfExists('casuals');
    }
};