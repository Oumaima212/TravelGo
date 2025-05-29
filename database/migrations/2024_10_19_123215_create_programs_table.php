<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('prestataire_id');
                $table->text('description');
                $table->date('start_date');
                $table->date('end_date');
                $table->decimal('total_price', 10, 2)->nullable()->default(0);
                $table->decimal('profit', 10, 2)->nullable()->default(0);
                $table->foreign('prestataire_id')->references('id')->on('users')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('programs');
    }
}

