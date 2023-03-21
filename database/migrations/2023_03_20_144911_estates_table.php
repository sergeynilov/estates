<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->integer('price')->unsigned();
            $table->smallInteger('bedrooms')->unsigned();
            $table->smallInteger('bathrooms')->unsigned();
            $table->smallInteger('storeys')->unsigned();
            $table->smallInteger('garages')->unsigned();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index(['name', 'price'], 'estates_name_price_index');
            $table->index(['name', 'bedrooms'], 'estates_name_bedrooms_index');
            $table->index(['name', 'bathrooms'], 'estates_name_bathrooms_index');
            $table->index(['name', 'storeys'], 'estates_name_storeys_index');
            $table->index(['name', 'garages'], 'estates_name_garages_index');

        });
        \Artisan::call('db:seed', array('--class' => 'estatesWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estates');
    }
};
