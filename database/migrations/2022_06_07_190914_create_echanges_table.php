<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('echanges', function (Blueprint $table) {
            $table->id();
            $table->enum('etape', ["1","2","3","4","5","6"]);
            $table->string('sens');
            $table->string('expediteur');
            $table->string('destinataire');
            $table->date('date_exp');
            $table->date('date_cloture')->nullable();;
            $table->string('fichier')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('contrat_id')->constrained();
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
        Schema::dropIfExists('echanges');
    }
}
