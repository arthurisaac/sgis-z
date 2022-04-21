<form action="{{ route('transfert.store') }}" method="post" id="newTransfertForm" novalidate>
    @csrf

    <input type="hidden" name="transfertPar" id="transfertPar" value="{{ Auth::user()->id }}" class="form-control" required/>
    <div class="d-flex flex-column mb-7 fv-row">
        <label class="form-label fs-6 fw-bolder text-dark"
               for="numeroTransfert">{{__('Numéro de transfert')}}</label>
        <input type="text" name="numeroTransfert" id="numeroTransfert" value="{{ $numeroDeTransfert }}"
               class="form-control form-control-solid" required readonly/>
    </div>
    <div class="row mb-10">
        <div class="col">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark"
                       for="typeDocumentEmetteur">{{__('Type document émetteur')}}</label>
                <select name="typeDocumentEmetteur" id="typeDocumentEmetteur" class="form-select form-select-solid typeDocumentEmetteur" data-hide-search="true">
                    <option value="CNIB">CNIB</option>
                    <option value="PASSPORT">PASSPORT</option>
                </select>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="numeroDocumentEmetteur">Numéro document émetteur</label>
                <input type="text" name="numeroDocumentEmetteur" id="numeroDocumentEmetteur"
                       class="form-control form-control-solid numeroDocumentEmetteur" list="cnib"/>
                <datalist id="cnib"></datalist>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="nomEmetteur">Nom de l'émetteur</label>
                <input type="text" name="nomEmetteur" id="nomEmetteur" class="form-control form-control-solid nomEmetteur" required/>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="telephoneEmetteur">Téléphone de l'émetteur</label>
                <input type="text" name="telephoneEmetteur" id="telephoneEmetteur" class="form-control form-control-solid telephoneEmetteur" required/>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="nomBeneficiaire">Nom du bénéficiaire</label>
                <input type="text" name="nomBeneficiaire" id="nomBeneficiaire" class="form-control form-control-solid nomBeneficiaire" required/>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="telephoneEmetteur">Téléphone bénéficiaire</label>
                <input type="tel" name="telephoneEmetteur" id="telephoneEmetteur"
                       class="form-control form-control-solid" required/>
            </div>
        </div>
        <div class="col">
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="codeTransfert">Code de transfert</label>
                <input type="number" name="codeTransfert" id="codeTransfert" value="{{ str_pad($nextId, 4, '0', STR_PAD_LEFT) }}" class="form-control form-control-solid codeTransfert"/>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="typeTransfert">Type de transfert</label>
                <select name="typeTransfert" id="typeTransfert" class="form-control form-control-solid typeTransfert">
                    <option>SGIS-Z</option>
                    <option>OM</option>
                    <option>FLOOZ</option>
                </select>
            </div>
            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="montantTransfert">Montant de transfert</label>
                <input type="number" name="montantTransfert" id="montantTransfert"
                       class="form-control form-control-solid" value="0"/>
            </div>

            <div class="d-flex flex-column mb-7 fv-row">
                <label class="form-label fs-6 fw-bolder text-dark" for="fraisTransfert">Frais de transfert</label>
                <input type="number" name="fraisTransfert" id="fraisTransfert"
                       class="form-control form-control-solid fraisTransfert" value="0"/>
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Enregistrer</button>
</form>
<script>
    const transferts = @json($transferts);
    const cnibs = document.getElementById('cnib');
    transferts.forEach(function (transfert) {
        let option = document.createElement('option');
        option.value = transfert.numeroDocumentEmetteur;
        cnibs.appendChild(option);
    })
</script>
