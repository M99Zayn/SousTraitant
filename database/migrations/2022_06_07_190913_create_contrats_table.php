<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->string('identifiant');
            $table->enum('type', ["Contrat","Avenant"]);
            $table->date('date_signature');
            $table->string('objet');
            $table->double('montant');
            $table->integer('duree');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('statut');
            $table->foreignId('soustraitant_id')->constrained();
            $table->foreignId('affaire_id')->constrained();
            $table->foreignId('contrat_id')->nullable()->constrained();
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
        Schema::dropIfExists('contrats');
    }
}
