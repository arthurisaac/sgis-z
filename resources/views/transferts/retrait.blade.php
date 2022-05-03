@extends("layouts.base")

@section('boutton-transfert')
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-3 py-md-1">
        <!--begin::Button-->
        <a href="#" class="btn btn-bg-white btn-active-color-primary"
           class="btn btn-bg-white btn-active-color-primary" data-bs-toggle="modal"
           data-bs-target="#newTransfertModal" id="kt_toolbar_primary_button">{{ __('Nouveau') }}</a>
        <!--end::Button-->
    </div>
    <!--end::Actions-->
@endsection
@section('toolbar-title')
    Retrait uniquement
@endsection

@section('main')

    <div class="row">
        <div class="col-xxl-8">
            <div class="card card-xxl-stretch  mb-5 mb-xl-8">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex flex-stack flex-wrap">
                        <div class="me-2">
                            <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Retrait en cours</a>
                            <div class="text-muted fs-7 fw-bold">Transferts non retiré</div>
                        </div>
                        <div
                            class="fw-bolder fs-3 text-primary">{{ $pendingTransfert->sum('montantTransfert') }}</div>
                    </div>

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
                    <div class="table-responsive">
                        <table class="table table-striped table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>No Transfert</th>
                                <th>Emetteur</th>
                                <th>Bénéficiaire</th>
                                <th>Montant</th>
                                <th>Date de transfert</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pendingTransfert as $transfert)
                                <tr>
                                    <td>{{ $transfert->codeTransfert }}</td>
                                    <td>{{ $transfert->numeroTransfert }}</td>
                                    <td>{{ $transfert->nomEmetteur }}</td>
                                    <td>{{ $transfert->nomBeneficiaire }}</td>
                                    <td>{{ $transfert->montantTransfert }}</td>
                                    <td>{{ $transfert->dateTransfert }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-icon"
                                           onclick="showOnTransfertModal({{$transfert}})">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <!--begin::Stats-->
                    <div class="flex-grow-1 card-p pb-0">
                        <div class="d-flex flex-stack flex-wrap">
                            <div class="me-2">
                                <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Rapport</a>
                                <div class="text-muted fs-7 fw-bold">Entrée de caisse</div>
                            </div>
                            <div class="fw-bolder fs-3 text-primary">
                                {{ number_format($transfertsOfDay->where('transfertPar', \Illuminate\Support\Facades\Auth::user()->id)
                                ->whereBetween('dateTransfert', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:00')])
                                ->sum('montantTransfert'),0, ',', ' ') }}
                            </div>
                        </div>
                    </div>
                    <!--end::Stats-->
                    <!--begin::Chart-->
                    <div class="widget-day-report-chart card-rounded-bottom" data-kt-chart-color="primary"
                         style="height: 150px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <div class="card card-xxl-stretch-50 mb-5 mb-xl-8 bg-warning">
                <!--begin::Body-->
                <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                    <!--begin::Hidden-->
                    <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
                        <div class="me-2">
                            <span class="fw-bolder text-gray-100 d-block fs-3">Rapport</span>
                            <span class="text-white fw-bold">Sortie de caisse</span>
                        </div>
                        <div class="fw-bolder fs-3 text-black">
                            {{ number_format($transfertsOfDay->where('confirmationTransfertPar', \Illuminate\Support\Facades\Auth::user()->id)
                                ->whereBetween('dateTransfert', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:00')])
                                ->sum('montantTransfert'), 0, ',', ' ' )}}
                        </div>
                    </div>
                    <!--end::Hidden-->
                    <!--begin::Chart-->
                    {{--<div class="widget-day-report-chart" data-kt-color="primary" style="height: 175px"></div>--}}
                    <div class="mixed-widget-2-chart card-rounded-bottom bg-warning" data-kt-color="warning"
                         style="height: 175px"></div>
                    <!--end::Chart-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transfertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfert N° <span id="numeroTransfertShow"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editTransfertForm" method="post" action="#" class="text-start">
                    @method('PATCH')
                    @csrf

                    <input type="hidden" name="transfertID" id="transfertID" class="form-control" required/>
                    <input type="hidden" name="confirmationTransfertPar" id="confirmationTransfertPar"
                           value="{{ Auth::user()->id }}" class="form-control" required/>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <h6>Transfert: <span id="typeTransfertShow"></span></h6>
                                <h6>Nom de l'envoyeur: <span id="nomEmetteurShow"></span></h6>
                                <h6>Nom receveur: <span id="nomBeneficiaireShow"></span></h6>
                                <h6>Document envoyeur: <span id="typeDocumentEmetteurShow"></span></h6>
                                <h6>Numéro document envoyeur: <span id="numeroDocumentEmetteurShow"></span></h6>
                                <h6>Document délivré le: <span id="documentEmetteurDelivreLeShow"></span></h6>
                                <h6>Téléphone envoyeur: <span id="telephoneEmetteurShow"></span></h6>
                                <h6>Téléphone receveur: <span id="telephoneBeneficiaireShow"></span></h6>
                                <br>
                                <h1>Montant  <span id="montantTransfertShow" class="text-danger"></span></h6>
                                <h6 class="p-4 bg-danger text-white" id="montantTransfertLetterShow"></h6>
                            </div>
                            <div class="col"></div>
                            <div class="col text-center">
                                <p>Code tranfert</p>
                                <div class="bg-primary p-9" style="border-radius: 8px;">
                                    <h1 style="font-size: 35px;"><span id="codeTransfertShow"></span></h1>
                                </div>
                            </div>
                        </div>
                        <div id="confirmation-form">
                            <hr>
                            <h1>Retrait</h1>
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex flex-column mb-6 fv-row">
                                        <label class="form-label fs-6 fw-bolder text-dark" for="typeDocumentBeneficiaireEdit">Type document bénéficiaire</label>
                                        <select name="typeDocumentBeneficiaire" id="typeDocumentBeneficiaireEdit"
                                                class="form-select form-select-solid">
                                            <option value="CNIB">CNIB</option>
                                            <option value="PASSPORT">PASSPORT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column mb-6 fv-row">
                                        <label class="form-label fs-6 fw-bolder text-dark" for="numeroDocumentBeneficiaireEdit">Numéro document</label>
                                        <input type="text" name="numeroDocumentBeneficiaire"
                                                id="numeroDocumentBeneficiaireEdit" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column mb-6 fv-row">
                                        <label class="form-label fs-6 fw-bolder text-dark" for="documentBeneficiaireDelivreLe">Document délivré le</label>
                                        <input type="text" name="documentBeneficiaireDelivreLe"
                                               id="documentBeneficiaireDelivreLe" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirmer transfert</button>
                        <button type="button" class="btn btn-secondary" onclick="dismissOneTransfertModal()">Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="newTransfertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Nouveau transfert d'argent</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                          transform="rotate(-45 6 17.3137)" fill="black"></rect>
									<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                          transform="rotate(45 7.41422 6)" fill="black"></rect>
								</svg>
							</span>
                    </div>
                </div>
                <div class="modal-body py-lg-10 px-lg-10">
                    @include('transferts.create-form')
                </div>
            </div>
        </div>
    </div>

    <div id="invoice" class="p-5 hide-invoice">
        <div class="row">
            <div class="col">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/world_icon.png') }}" alt=""
                         style="height: 50px; position:relative; top: -3px;">
                    <div style="margin-left: 10px;">
                        <h4>SINGBEOGO GLOBAL INTERNATIONAL SERVICE</h4>
                        <h5 class="text-gray-700">BUREAU DE TRANSFERT D'ARGENT ET DE CHANGE</h5>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <h6>Code : <strong><span id="invoice-code"></span></strong></h6>
                <h6>Montant : <strong><span id="invoice-montant"></span></strong></h6>
                <h6>Frais : <strong><span id="invoice-frais"></span></strong></h6>
            </div>
            <div class="col" style="text-align: right;">
                <div class="row">
                    <div class="col-4">Ouaga/Tel:</div>
                    <div class="col">
                        <div>Tel : (226) 70 48 65 30</div>
                        <div>Tel : (226) 76 28 56 35</div>
                        <div>Tel : (226) 76 81 89 02</div>
                    </div>
                </div>
            </div>
            <div class="col" style="text-align: right;">
                <div class="row">
                    <div class="col-4">Lomé/Tel:</div>
                    <div class="col">
                        <div>Tel : (228) 90 92 97 38</div>
                        <div>Tel : (228) 70 51 34 98</div>
                        <div>Tel : (228) 99 95 36 56</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-4">
                <div style="height: 80px; width: 100%; border: 2px solid black;">
                    <p class="text-center"> <span id="invoice-emetteur"></span> </p>
                </div>
                <p class="text-center pt-2">L'envoyeur</p>
            </div>
            <div class="col"></div>
            <div class="col-4">
                <div style="height: 80px; width: 100%; border: 2px solid black;"></div>
                <p class="text-center pt-2">Le caissier</p>
            </div>
        </div>
        <div class="row">
        </div>
        <br>
        <p class="text-center">{{ __("La SGIS-Z décline toute responsabilité s'il se révèle que les fonds proviennent d'origine criminelle ou de source illégale; Le déposant déclare que les fonds mis en dépôt ne sont pas criminelle, ne proviennent pas d'activités illégales et rassure connaître à qui il envoie.") }}</p>

    </div>
    <div id="invoice-confirmation" class="p-5 hide-invoice">
        <div class="row">
            <div class="col">
                <div style="display: flex; align-items: center;">
                    <img src="{{ asset('images/world_icon.png') }}" alt=""
                         style="height: 50px; position:relative; top: -3px;">
                    <div style="margin-left: 10px;">
                        <h4>SINGBEOGO GLOBAL INTERNATIONAL SERVICE</h4>
                        <h5 class="text-gray-700">BUREAU DE TRANSFERT D'ARGENT ET DE CHANGE</h5>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <h6>Code : <strong><span id="invoice-code-confirmation"></span></strong></h6>
                <h6>Montant : <strong><span id="invoice-montant-confirmation"></span></strong></h6>
                <h6>Nom du bénéficiaire : <strong><span id="invoice-beneficiaire-confirmation"></span></strong></h6>
            </div>
            <div class="col" style="text-align: right;">
                <div class="row">
                    <div class="col-4">Ouaga/Tel:</div>
                    <div class="col">
                        <div>Tel : (226) 70 48 65 30</div>
                        <div>Tel : (226) 76 28 56 35</div>
                        <div>Tel : (226) 76 81 89 02</div>
                    </div>
                </div>
            </div>
            <div class="col" style="text-align: right;">
                <div class="row">
                    <div class="col-4">Lomé/Tel:</div>
                    <div class="col">
                        <div>Tel : (228) 90 92 97 38</div>
                        <div>Tel : (228) 70 51 34 98</div>
                        <div>Tel : (228) 99 95 36 56</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-4">
                <div style="height: 80px; width: 100%; border: 2px solid black;">
                    <p class="text-center"> <span id="invoice-receveur"></span> </p>
                </div>
                <p class="text-center pt-2">Le receveur</p>
            </div>
            <div class="col"></div>
            <div class="col-4">
                <div style="height: 80px; width: 100%; border: 2px solid black;"></div>
                <p class="text-center pt-2">Le caissier</p>
            </div>
        </div>
        <div class="row">
        </div>
        <br>
        <p class="text-center">{{ __("La SGIS-Z décline toute responsabilité s'il se révèle que les fonds proviennent d'origine criminelle ou de source illégale; Le déposant déclare que les fonds mis en dépôt ne sont pas criminelle, ne proviennent pas d'activités illégales et rassure connaître à qui il envoie.") }}</p>

    </div>

    <script>
        const dailyStatsIncome = @json($dailyStatsIncome);
        const dailyStatsOutGoing = @json($dailyStatsOutGoing);
        window.onload = () => {
            const dailyStatsIncomeCategories = [];
            const dailyStatsIncomeData = [];
            dailyStatsIncome.map(stat => {
                dailyStatsIncomeCategories.push(stat.heure);
                dailyStatsIncomeData.push(stat.montant);
            });

            const dailyStatsOutGoingCategories = [];
            const dailyStatsOutGoingData = [];
            dailyStatsOutGoing.map(stat => {
                dailyStatsOutGoingCategories.push(stat.heure);
                dailyStatsOutGoingData.push(stat.montant);
            });
            linearMonthStatsReport(dailyStatsIncomeCategories, dailyStatsIncomeData, '.mixed-widget-2-chart');
            linearStatsReport(dailyStatsOutGoingCategories, dailyStatsOutGoingData, '.widget-day-report-chart');
        }
    </script>
@endsection
