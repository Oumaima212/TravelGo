<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('photo')->nullable(); // Optional profile photo
            $table->string('name'); // User's full name
            $table->string('role')->default('user'); // User's role, default is 'user'
            $table->string('phone')->nullable(); // Optional phone number
            $table->string('email')->unique(); // User's email, must be unique
            $table->string('status')->default('active')->nullable(); // Status, default is 'active'
            $table->date('dateJoined')->default(now()); // Date joined, defaults to current date
            $table->string('password'); // User's password
            $table->string('genre')->nullable(); // Optional field for genre (gender, etc.)
            $table->rememberToken(); // Token for "remember me" functionality
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users'); // Drops the users table if it exists
    }
}
