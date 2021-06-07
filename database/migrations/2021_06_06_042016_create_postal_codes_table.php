<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->string('suburb', 100)->nullable();
            $table->string('suburb_type', 100)->nullable();
            $table->string('township', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('cp', 100)->nullable();
            $table->string('state_code', 50)->nullable();
            $table->string('office_code', 50)->nullable();
            $table->string('township_code', 50)->nullable();
            $table->string('suburb_code', 50)->nullable();
            $table->string('zone', 100)->nullable();
            $table->string('city_code', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postal_codes');
    }
}
