<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramExtraTable extends Migration
{
    public function up()
    {
        Schema::create('program_extra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('extra_id')->constrained('extras')->onDelete('cascade');
            $table->foreignId('extra_details_id')->nullable()->constrained('extra_details')->onDelete('set null');
            $table->decimal('extra_sale_price', 10, 2); // Le prix de vente spécifique
            $table->timestamps(); // Pour les dates de création et de mise à jour
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_extra');
    }
}
