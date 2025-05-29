<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom de la charge (ex: "Salaire Janvier")
            $table->string('type_charge'); // Type de charge (ex: salaire, entretien, etc.)
            $table->decimal('montant', 10, 2); // Montant de la charge
            $table->date('date_charge'); // Date de la charge
            $table->text('description')->nullable(); // Description optionnelle
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
}
