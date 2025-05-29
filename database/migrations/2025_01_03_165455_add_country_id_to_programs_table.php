<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdToProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('id'); // Ajoute la colonne après 'id'
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['country_id']); // Supprime la contrainte de clé étrangère
            $table->dropColumn('country_id');   // Supprime la colonne
        });
    }
}
