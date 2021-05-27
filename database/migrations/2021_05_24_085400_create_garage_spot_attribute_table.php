<?php

use App\Models\Garage;
use App\Models\SpotAttribute;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarageSpotAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garage_spot_attribute', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Garage::class);
            $table->foreignIdFor(SpotAttribute::class);
            $table->integer('price_per_hour')->comment('cents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garage_spot_attribute');
    }
}
