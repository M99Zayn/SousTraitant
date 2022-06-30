<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoustraitantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('soustraitants', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant');
            $table->string('raison_sociale');
            $table->string('addresse');
            $table->string('telephone');
            $table->string('email');
            $table->string('domaine');
            $table->date('date_anciennete');
            $table->boolean('patente');
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soustraitants');
    }
}
