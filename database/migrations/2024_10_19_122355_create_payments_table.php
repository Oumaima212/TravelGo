<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->date('date');
            $table->string('method');
            $table->string('status');
            $table->string('transactionNumber')->unique();
            
            $table->unsignedBigInteger('idClient');
            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

