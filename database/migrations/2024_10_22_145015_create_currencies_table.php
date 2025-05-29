<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('currencyName');
            $table->float('exchangeRate');
            $table->boolean('isDefault')->default(false);
            $table->unsignedBigInteger('idCountry');
            $table->timestamps();

            // Foreign key
            $table->foreign('idCountry')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
