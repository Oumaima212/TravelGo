<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdextraToExtraDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('extra_details', function (Blueprint $table) {
            // Ajouter la colonne idExtra
            $table->unsignedBigInteger('idExtra')->after('id'); // Après la colonne 'id'

            // Ajouter un index sur idExtra pour accélérer les recherches
            $table->index('idExtra');

            // Définir la clé étrangère
            $table->foreign('idExtra')
                  ->references('id')
                  ->on('extras')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('extra_details', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['idExtra']);

            // Supprimer l'index
            $table->dropIndex(['idExtra']);

            // Supprimer la colonne idExtra
            $table->dropColumn('idExtra');
        });
    }
}
