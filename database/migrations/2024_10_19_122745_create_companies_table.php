<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->float('serviceFee');
            $table->string('invoicePrefix');
            $table->integer('invoiceNumber');
            $table->string('paymentPrefix');
            $table->integer('paymentNumber');
            $table->text('biography')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
