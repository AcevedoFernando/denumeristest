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
            $table->mediumInteger('code')->primary();
            $table->string('suburb', 100);
            $table->string('suburb_type', 100);
            $table->string('township', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('cp', 100);
            $table->string('state_code', 20);
            $table->string('office_code', 20);
            $table->string('township_code', 20);
            $table->string('suburb_code', 20);
            $table->string('zone', 100);
            $table->string('city_code', 20);
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
