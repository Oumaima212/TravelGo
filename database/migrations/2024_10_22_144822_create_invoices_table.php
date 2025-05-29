<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the 'invoices' table already exists
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id(); // This is a big integer and will work as a primary key
                $table->string('invoiceReference');
                $table->date('invoiceDate');
                $table->float('totalAmount');
                $table->float('amountDue');
                $table->float('discount')->nullable();
                $table->string('paymentMethod'); // Nouveau champ : méthode de paiement
                $table->float('paidAmount')->default(0); // Nouveau champ : montant payé
                $table->float('remainingAmount')->default(0); // Nouveau champ : montant restant
                $table->text('paymentDescription')->nullable();
                $table->unsignedBigInteger('idClient');
                $table->unsignedBigInteger('idProgram');
                $table->unsignedBigInteger('reservation_id')->unique()->nullable();
                $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
                $table->timestamps();
                $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
                $table->foreign('idProgram')->references('id')->on('programs')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
