<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraDetailsTable extends Migration
{
    public function up()
    {
            Schema::create('extra_details', function (Blueprint $table) {
                $table->id();
                $table->string('extraCompanyName');
                $table->double('extraPurchasePrice', 8, 2);
                $table->double('extraSalePrice', 8, 2);
                $table->timestamps();
            });


    }

    public function down()
    {
        Schema::dropIfExists('extra_details');
    }

}
