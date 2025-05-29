<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id('idClient');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('last_name_arabic')->nullable();
            $table->string('first_name_arabic')->nullable();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('country');
            $table->string('passport_number')->nullable();
            $table->string('phone')->unique();
            $table->string('affiliate')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('id_company')->nullable();
            $table->string('cin')->unique();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
