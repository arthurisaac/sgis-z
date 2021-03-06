<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    use HasFactory;
    protected $fillable = [
        'numeroTransfert',
        'dateTransfert',
        'dateConfirmationRetrait',
        'confirmationRetrait',
        'codeTransfert',
        'typeTransfert',
        'montantTransfert',
        'fraisTransfert',
        'nomEmetteur',
        'nomBeneficiaire',
        'typeDocumentEmetteur',
        'typeDocumentBeneficiaire',
        'numeroDocumentEmetteur',
        'numeroDocumentBeneficiaire',
        'telephoneEmetteur',
        'telephoneBeneficiaire',
        'documentEmetteurDelivreLe',
        'documentBeneficiaireDelivreLe',
        'retraitVu',
        'transfertPar',
        'confirmationTransfertPar',
    ];

    function deposerPar() {
        return $this->belongsTo('App\Models\User', 'transfertPar', 'id');
    }

    function retraitPar() {
        return $this->belongsTo('App\Models\User', 'confirmationTransfertPar', 'id');
    }
}
