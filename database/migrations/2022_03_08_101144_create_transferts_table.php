<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->string('numeroTransfert');
            $table->timestamp('dateTransfert')->useCurrent();
            $table->timestamp('dateConfirmationRetrait')->nullable();
            $table->boolean('confirmationRetrait')->nullable()->default(false);
            $table->string('codeTransfert')->nullable();
            $table->string('typeTransfert')->nullable();
            $table->double('montantTransfert')->default(0);
            $table->double('fraisTransfert')->default(0);
            $table->string('nomEmetteur')->nullable();
            $table->string('nomBeneficiaire')->nullable();
            $table->string('typeDocumentEmetteur')->nullable();
            $table->string('typeDocumentBeneficiaire')->nullable();
            $table->string('numeroDocumentEmetteur')->nullable();
            $table->string('numeroDocumentBeneficiaire')->nullable();
            $table->string('telephoneEmetteur')->nullable();
            $table->string('telephoneBeneficiaire')->nullable();
            $table->foreignId('retraitVu')->nullable()->references('id')->on('users');
            $table->foreignId('transfertPar')->references('id')->on('users');
            $table->foreignId('confirmationTransfertPar')->nullable()->references('id')->on('users');
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
        Schema::dropIfExists('transferts');
    }
}
