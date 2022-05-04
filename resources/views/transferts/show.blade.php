@extends("layouts.base")

@section('main')
    <div class="card card-xxl-stretch">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div>
                

                <input type="hidden" name="transfertPar" id="transfertPar" value="{{ Auth::user()->id }}"
                       class="form-control" required/>
                <div class="d-flex flex-column mb-7 fv-row">
                    <label class="form-label fs-6 fw-bolder text-dark"
                           for="numeroTransfert">{{__('Numéro de transfert')}}</label>
                    <input type="text" name="numeroTransfert" id="numeroTransfert"
                           value="{{ $transfert->numeroTransfert }}"
                           class="form-control form-control-solid" required readonly/>
                </div>
                <div class="row mb-10">
                    <div class="col">
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark"
                                   for="typeDocumentEmetteur">{{__('Type document émetteur')}}</label>
                            <select name="typeDocumentEmetteur" id="typeDocumentEmetteur"
                                    class="form-select form-select-solid typeDocumentEmetteur" data-hide-search="true">
                                <option value="CNIB">CNIB</option>
                                <option value="PASSPORT">PASSPORT</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="numeroDocumentEmetteur">Numéro
                                document émetteur</label>
                            <input type="text" name="numeroDocumentEmetteur" value="{{$transfert->numeroDocumentEmetteur}}" id="numeroDocumentEmetteur"
                                   class="form-control form-control-solid numeroDocumentEmetteur"/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="nomEmetteur">Nom de
                                l'émetteur</label>
                            <input type="text" name="nomEmetteur" id="nomEmetteur" value="{{$transfert->nomEmetteur}}"
                                   class="form-control form-control-solid nomEmetteur" required/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="telephoneEmetteur">Téléphone de
                                l'émetteur</label>
                            <input type="text" name="telephoneEmetteur" id="telephoneEmetteur"
                                   class="form-control form-control-solid telephoneEmetteur"
                                   value="{{$transfert->telephoneEmetteur}}" required/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="nomBeneficiaire">Nom du
                                bénéficiaire</label>
                            <input type="text" name="nomBeneficiaire" id="nomBeneficiaire"
                                   value="{{$transfert->nomBeneficiaire}}"
                                   class="form-control form-control-solid nomBeneficiaire" required/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="codeTransfert">Code de
                                transfert</label>
                            <input type="number" name="codeTransfert" id="codeTransfert"
                                   value="{{ str_pad($transfert->codeTransfert, 4, '0', STR_PAD_LEFT) }}"
                                   class="form-control form-control-solid codeTransfert"/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="typeTransfert">Type de
                                transfert</label>
                            <select name="typeTransfert" id="typeTransfert"
                                    class="form-control form-control-solid typeTransfert">
                                <option>{{$transfert->typeTransfert}}</option>
                                <option>SGIS-Z</option>
                                <option>OM</option>
                                <option>FLOOZ</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="montantTransfert">Montant de
                                transfert</label>
                            <input type="number" name="montantTransfert" id="montantTransfert"
                                   value="{{$transfert->montantTransfert}}"
                                   class="form-control form-control-solid"/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="fraisTransfert">Frais de
                                transfert</label>
                            <input type="number" name="fraisTransfert" id="fraisTransfert"
                                   value="{{$transfert->fraisTransfert}}"
                                   class="form-control form-control-solid fraisTransfert"/>
                        </div>
                        <div class="d-flex flex-column mb-7 fv-row">
                            <label class="form-label fs-6 fw-bolder text-dark" for="telephoneBeneficiaire">Téléphone
                                bénéficiaire</label>
                            <input type="tel" name="telephoneBeneficiaire" id="telephoneBeneficiaire"
                                   class="form-control form-control-solid" value="{{$transfert->telephoneBeneficiaire}}"
                                   required/>
                        </div>
                    </div>
                </div>
                <div id="confirmation-form">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="typeDocumentBeneficiaireEdit">Type document bénéficiaire</label>
                                <select name="typeDocumentBeneficiaire" id="typeDocumentBeneficiaireEdit"
                                        class="form-select form-select-solid">
                                    <option>{{$transfert->typeDocumentBeneficiaire}}</option>
                                    <option value="CNIB">CNIB</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="numeroDocumentBeneficiaireEdit">Numéro document</label>
                                <input type="text" name="numeroDocumentBeneficiaire" value="{{ $transfert->numeroDocumentBeneficiaire }}"
                                        id="numeroDocumentBeneficiaireEdit" class="form-control"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="documentBeneficiaireDelivreLe">Document délivré le</label>
                                <input type="text" name="documentBeneficiaireDelivreLe" value="{{ $transfert->documentBeneficiaireDelivreLe }}"
                                        id="documentBeneficiaireDelivreLe" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="trasnfererLe">Transfert crée le</label>
                                <input type="text" name="trasnfererLe" value="{{ date('d-m-Y à H:i:s', strtotime($transfert->dateTransfert)) }}"
                                        id="trasnfererLe" class="form-control"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="deposerPar">Transfert crée par</label>
                                <input type="text" name="deposerPar" value="{{ $transfert->deposerPar->name ?? '' }}"
                                        id="deposerPar" class="form-control form-control-solid" readonly/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="confirmerLe">Retrait confirmé le</label>
                                <input type="text" name="confirmerLe" value="{{ date('d-m-Y à H:i:s', strtotime($transfert->dateConfirmationRetrait)) }}"
                                        id="confirmerLe" class="form-control"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-column mb-6 fv-row">
                                <label class="form-label fs-6 fw-bolder text-dark" for="confirmerPar">Retrait confirmé par</label>
                                <input type="text" name="confirmerPar" value="{{ $transfert->retraitPar->name ?? '' }}"
                                        id="confirmerPar" class="form-control form-control-solid" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            </script>
        </div>
    </div>
@endsection
