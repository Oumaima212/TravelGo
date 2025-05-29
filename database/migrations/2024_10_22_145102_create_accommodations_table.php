<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('role');
            $table->string('phone')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('status');
            $table->date('dateJoined');
            $table->string('address')->nullable()->change();
            $table->float('distance');
            $table->string('type');
            // $table->unsignedBigInteger('idProgram');
            $table->timestamps();

            // Foreign key
            // $table->foreign('idProgram')->references('id')->on('programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
    }
}
