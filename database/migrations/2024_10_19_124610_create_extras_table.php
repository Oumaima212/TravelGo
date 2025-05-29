<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtrasTable extends Migration
{
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->id(); // Clé primaire de type unsignedBigInteger
            $table->string('type');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('extras');
    }
}
