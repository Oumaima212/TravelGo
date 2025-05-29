<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('idInvitation');
            $table->string('email');
            $table->date('invitationDate');
            $table->enum('status', ['pending', 'accepted'])->default('pending');
            $table->unsignedBigInteger('idUser');
            $table->string('token')->nullable();

            $table->timestamps();
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
