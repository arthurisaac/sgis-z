@extends("layouts.base")

@section('boutton-transfert')
    <div class="d-flex align-items-center py-3 py-md-1">
        <div class="me-4">
            <a href="#"
               class="btn btn-custom btn-active-white btn-flex btn-color-white btn-active-color-primary fw-bolder"
               data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
											<path
                                                d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                fill="black"></path>
										</svg>
									</span>Filtrer</a>
            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                 id="kt_menu_61484fe00ce0c">
                <div class="px-7 py-5">
                    <div class="fs-5 text-dark fw-bolder">Options</div>
                </div>
                <div class="separator border-gray-200"></div>
                <div class="px-7 py-5">
                    <form action="#" method="GET">
                        @csrf
                        {{--<div class="mb-10">
                            <label class="form-label fw-bold">Status:</label>
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_61484fe00ce0c" data-allow-clear="true">
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>--}}
                        <div class="mb-10">
                            <label class="form-label fw-bold">Date d??but:</label>
                            <div>
                                <input type="date" name="debut" value="{{ $debut }}"
                                       class="form-control form-control-solid"/>
                            </div>
                        </div>
                        <div class="mb-10">
                            <label class="form-label fw-bold">Date fin:</label>
                            <div>
                                <input type="date" name="fin" value="{{ $fin }}"
                                       class="form-control form-control-solid"/>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true">Annuler
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('toolbar-title')
    Historiques transferts
@endsection

@section('main')

    <div class="row">
        <div class="col-xxl-8">
            <div class="card card-xxl-stretch  mb-5 mb-xl-8">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex flex-stack flex-wrap">
                        <div class="me-2">
                            <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Transferts</a>
                            <div class="text-muted fs-7 fw-bold">
                                @if ($query == 'tout') Toutes les op??rations effectu??es
                                @elseif ($query == 'retrait') Tous les retraits effectu??s
                                @elseif ($query == 'depot') Tous les d??p??t effectu??s @endif
                                @if (isset($debut) && isset($fin)) <span> du {{ $debut }}</span> au
                                <span>{{ $fin }}</span> @else <span> depuis le d??but</span> @endif</div>
                        </div>
                        <div class="fw-bolder fs-3 text-primary">{{ $transferts->sum('montantTransfert') }}</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Emetteur</th>
                                <th>B??n??ficiaire</th>
                                <th>Montant</th>
                                <th>Transfert le</th>
                                <th>Retrait le</th>
                                <th class="col-1">Par</th>
                                <th class="col-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transferts as $transfert)
                                <tr>
                                    <td>{{ $transfert->codeTransfert }}</td>
                                    <td>{{ $transfert->nomEmetteur }}</td>
                                    <td>{{ $transfert->nomBeneficiaire }}</td>
                                    <td>{{ number_format($transfert->montantTransfert) }}</td>
                                    <td>{{date('d/m/Y ?? H:i:s', strtotime($transfert->dateTransfert))}}</td>
                                    <td> @if ($transfert->confirmationRetrait == 1)
                                            {{date('d/m/Y ?? H:i:s', strtotime($transfert->dateConfirmationRetrait))}}
                                        @else <span
                                                class="badge  badge-light-warning fs-8 fw-bolder">En attente de retrait</span>
                                        @endif
                                    </td>
                                    <td><small
                                            style="text-transform: capitalize;">{{ $transfert->deposerPar->name ?? ""}}</small>
                                    </td>
                                    <td>
                                        @if ($transfert->confirmationRetrait)
                                        <a class="btn btn-sm btn-dark"
                                        href="{{ route('transfert.show', $transfert->id) }}"></a>
                                        @else
                                        <a class="btn btn-sm btn-primary"
                                        href="{{ route('transfert.edit', $transfert->id) }}"></a>
                                        <button class="btn btn-sm btn-danger"
                                                onclick="deleteOneTransfert({{$transfert->id}})"></button>
                                        @endif
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
                <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                    <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
                        <div class="me-2">
                            <span class="fw-bolder d-block fs-3">Filtre</span>
                            <span class="text-black-50 fw-bold">Filtre par moment</span>
                        </div>
                        <div class="fw-bolder fs-3 text-black"></div>
                    </div>
                    <div class="card-body">
                        <form action="#" method="get">
                            @csrf

                            <div class="row mb-10">
                                <div class="col">
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <label class="form-label fs-6 fw-bolder text-dark" for="dateDebut">Date
                                            debut</label>
                                        <input type="date" name="debut" id="dateDebut" value="{{ $debut }}"
                                               class="form-control form-control-solid numeroDocumentEmetteur"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <label class="form-label fs-6 fw-bolder text-dark" for="dateFin">Date
                                            fin</label>
                                        <input type="date" name="fin" id="dateFin" value="{{ $fin }}"
                                               class="form-control form-control-solid numeroDocumentEmetteur"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                <div class="card-body d-flex flex-column p-0">
                    <div class="card-p pb-0">
                        <div class="d-flex flex-stack flex-wrap">
                            <div class="me-2">
                                <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Rapport</a>
                                <div class="text-muted fs-7 fw-bold">Tous les chiffres</div>
                            </div>
                            <div class="fw-bolder fs-3 text-primary"></div>
                        </div>
                    </div>
                    <div class="p-10 pt-0">
                        <div>Total transferts : <strong
                                class="text-danger">{{ number_format( $transferts->sum('montantTransfert') ) }}</strong>
                        </div>
                        {{--<div>Total frais de transfert : {{ number_format( $transferts->sum('fraisTransfert') ) }}</div>--}}
                        <div>Total envoi Ouagadougou
                            : {{ number_format( $envoiOuagadougou->sum('montantTransfert') ) }}</div>
                        <div>Total retrait Ouagadougou
                            : {{ number_format( $retraitOuagadougou->sum('montantTransfert') ) }}</div>
                        <hr>
                        <div>Total en attente : <span
                                class="text-warning">{{ number_format( $transfertEnAttente->sum('montantTransfert') ) }}</span>
                        </div>
                        <hr>
                        <div>Total envoi Lom?? : {{ number_format( $envoiLome->sum('montantTransfert') ) }}</div>
                        <div>Total retrait Lom?? : {{ number_format( $retraitLome->sum('montantTransfert') ) }}</div>
                        <hr>
                        {{--<div>Total retrait par Lom?? : {{ number_format( $totalTransfertLome ) }}</div>--}}
                        <div>Transfert le plus ??lev?? : {{ number_format($transferts->max('montantTransfert')) }}</div>
                        <div>Transfert le plus bas : {{ number_format($transferts->min('montantTransfert')) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transfertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="confirmationTransfertPar" id="confirmationTransfertPar"
                       value="{{ Auth::user()->id }}" class="form-control" required/>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="numeroTransfertShow">Num??ro de transfert</label>
                        <input type="text" name="numeroTransfert" id="numeroTransfertShow" class="form-control" required
                               readonly/>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nomEmetteurShow">Nom de l'??metteur</label>
                                <input type="text" name="nomEmetteur" id="nomEmetteurShow" class="form-control"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label for="nomBeneficiaireShow">Nom du b??n??ficiaire</label>
                                <input type="text" name="nomBeneficiaire" id="nomBeneficiaireShow" class="form-control"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label for="typeDocumentEmetteurShow">Type document ??metteur</label>
                                <select name="typeDocumentEmetteur" id="typeDocumentEmetteurShow" class="form-control">
                                    <option value="CNIB">CNIB</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="numeroDocumentEmetteurShow">Num??ro document ??metteur</label>
                                <input type="text" name="numeroDocumentEmetteur" id="numeroDocumentEmetteurShow"
                                       class="form-control" list="cnib"/>
                                <datalist id="cnib">
                                    <option value="B122323232">
                                    <option value="B0329309203">
                                </datalist>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="codeTransfertShow">Code de transfert</label>
                                <input type="number" name="codeTransfert" id="codeTransfertShow" value=""
                                       class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="typeTransfertShow">Type de transfert</label>
                                <select name="typeTransfert" id="typeTransfertShow" class="form-control">
                                    <option>SGIS-Z</option>
                                    <option>OM</option>
                                    <option>FLOOZ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="montantTransfertShow">Montant de transfert</label>
                                <input type="number" name="montantTransfert" id="montantTransfertShow"
                                       class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="fraisTransfertShow">Frais de transfert</label>
                                <input type="number" name="fraisTransfert" id="fraisTransfertShow"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col">
                            {{-- <div class="form-group" id="confirmGroup">
                                 <label for="confirmationRetrait">Confirmer retrait</label>
                                 <input type="checkbox" name="confirmationRetrait" id="confirmationRetrait"
                                        class="form-check"/>
                             </div>--}}
                            <div class="form-group">
                                <label for="typeDocumentBeneficiaireShow">Type document b??n??ficiaire</label>
                                <select name="typeDocumentBeneficiaire" id="typeDocumentBeneficiaireShow"
                                        class="form-control">
                                    <option value="CNIB">CNIB</option>
                                    <option value="PASSPORT">PASSPORT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="numeroDocumentBeneficiaireShow">Nom document b??n??ficiaire</label>
                                <input type="text" name="numeroDocumentBeneficiaire" id="numeroDocumentBeneficiaireShow"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="dismissOneTransfertModal()">Fermer</button>
                </div>
            </div>
        </div>
    </div>

@endsection
