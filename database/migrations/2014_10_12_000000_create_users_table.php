<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('matricule')->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('role', [
                "Chef de projet",
                "Chef de division",
                "Directeur de pole",
                "Division controle de gestion",
                "DAF",
                "DG",
                "Service marché",
                "RH",
                "Cadre administrative",
                "Admin"])->nullable();
            $table->string('password')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
