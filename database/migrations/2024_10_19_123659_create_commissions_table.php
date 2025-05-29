<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    protected $table = 'commissions'; // Si le nom n'est pas standard.

    public function up()
{
    Schema::create('commissions', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('status');
        $table->timestamps(); // Pas de colonne idProgram ici
    });
}

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}
