<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Models\Transfert;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $nextId = DB::table('transferts')->max('id') + 1;
        $numeroDeTransfert = time() . '-' . $nextId;
        $transfertsOfDay = Transfert::query()->whereDate('dateTransfert', date('Y-m-d'))->get();
        $pendingTransfert = Transfert::query()->where('confirmationRetrait', '=', '0')->get();
        $transferts = Transfert::all();

        $dailyStatsIncome = Transfert::query()
            ->selectRaw('hour(dateTransfert) AS heure, SUM(montantTransfert) AS montant')
            ->whereDate('dateTransfert', date('Y-m-d'))
            ->where('transfertPar', Auth::user()->id)
            ->groupByRaw('hour(dateTransfert)')
            ->get();

        $dailyStatsOutGoing = Transfert::query()
            ->selectRaw('hour(dateTransfert) AS heure, SUM(montantTransfert) AS montant')
            ->whereDate('dateTransfert', date('Y-m-d'))
            ->where('confirmationTransfertPar', Auth::user()->id)
            ->groupByRaw('hour(dateTransfert)')
            ->get();
        return view('transferts.index', compact('nextId', 'numeroDeTransfert', 'pendingTransfert', 'transfertsOfDay', 'transferts', 'dailyStatsIncome', 'dailyStatsOutGoing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $nextId = DB::table('transferts')->max('id') + 1;
        $numeroDeTransfert = time() . '-' . $nextId;
        $transferts = Transfert::all();
        return view('transferts.create', compact('nextId', 'numeroDeTransfert', 'transferts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomEmetteur' => 'required',
            'nomBeneficiaire' => 'required',
            'typeTransfert' => 'required',
            'montantTransfert' => 'required',
            'fraisTransfert' => 'required',
            'telephoneBeneficiaire' => 'required',
        ]);

        $transfert = new Transfert([
            'numeroTransfert' => $request->get('numeroTransfert'),
            'nomEmetteur' => $request->get('nomEmetteur'),
            'nomBeneficiaire' => $request->get('nomBeneficiaire'),
            'typeDocumentEmetteur' => $request->get('typeDocumentEmetteur'),
            'numeroDocumentEmetteur' => $request->get('numeroDocumentEmetteur'),
            'documentEmetteurDelivreLe' => $request->get('documentEmetteurDelivreLe'),
            'codeTransfert' => $request->get('codeTransfert'),
            'typeTransfert' => $request->get('typeTransfert'),
            'montantTransfert' => $request->get('montantTransfert'),
            'fraisTransfert' => $request->get('fraisTransfert'),
            'telephoneBeneficiaire' => $request->get('telephoneBeneficiaire'),
            'telephoneEmetteur' => $request->get('telephoneEmetteur'),
            'transfertPar' => Auth::user()->id,
        ]);
        $transfert->save();
        return redirect()->to('/transfert')->with('success', 'Transfert enregistré');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $transfert = Transfert::query()->find($id);
        return view('transferts.show', compact('transfert', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $transferts = Transfert::all();
        $transfert = Transfert::query()->find($id);
        return view('transferts.edit', compact('transfert', 'transferts', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomEmetteur' => 'required',
            'nomBeneficiaire' => 'required',
            'numeroDocumentEmetteur' => 'required',
            'typeTransfert' => 'required',
            'montantTransfert' => 'required',
            'fraisTransfert' => 'required',
            'telephoneBeneficiaire' => 'required',
        ]);

        $transfert = Transfert::query()->find($id);
        $transfert->numeroTransfert = $request->get('numeroTransfert');
        $transfert->nomEmetteur = $request->get('nomEmetteur');
        $transfert->nomBeneficiaire = $request->get('nomBeneficiaire');
        $transfert->typeDocumentEmetteur = $request->get('typeDocumentEmetteur');
        $transfert->numeroDocumentEmetteur = $request->get('numeroDocumentEmetteur');
        $transfert->codeTransfert = $request->get('codeTransfert');
        $transfert->typeTransfert = $request->get('typeTransfert');
        $transfert->montantTransfert = $request->get('montantTransfert');
        $transfert->fraisTransfert = $request->get('fraisTransfert');
        $transfert->telephoneBeneficiaire = $request->get('telephoneBeneficiaire');
        $transfert->telephoneEmetteur = $request->get('telephoneEmetteur');
        $transfert->documentEmetteurDelivreLe = $request->get('documentEmetteurDelivreLe');
        $transfert->documentBeneficiaireDelivreLe = $request->get('documentBeneficiaireDelivreLe');

        $transfert->save();

        return redirect()->to('/transfert')->with('success', 'Modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $query
     * @return Factory|View
     */
    public function report(Request $request, $query) {
        $transferts = Transfert::query()->orderByDesc('id')->get();
        $debut = $request->get('debut');
        $fin = $request->get('fin');
        $envoiOuagadougou = Transfert::with('deposerPar')->whereHas('deposerPar', fn ($query) => 
        $query->where('city', 'like', 'Ouagadougou'))->get();
        $retraitOuagadougou = Transfert::query()->whereHas('retraitPar', fn ($query) => 
        $query->where('city', 'like', 'Ouagadougou'))->get();
        $transfertEnAttente = Transfert::query()
        ->where('confirmationRetrait', '=', 0);

        $envoiLome = Transfert::with('deposerPar')->whereHas('deposerPar', fn ($query) => 
        $query->where('city', 'like', 'Lomé'))->get();
        $retraitLome = Transfert::query()->whereHas('retraitPar', fn ($query) => 
        $query->where('city', 'like', 'Lomé'))->get();

        if (isset($query) && $query == 'depot') {
            $transferts = Transfert::query()
                ->where('transfertPar', Auth::user()->id)
                ->orderByDesc('id')
                ->get();
        }

        if (isset($query) && $query == 'retrait') {
            $transferts = Transfert::query()
                ->where('confirmationTransfertPar', Auth::user()->id)
                ->orderByDesc('id')
                ->get();
        }

        if (isset($debut) && isset($fin)) {
            $transferts = Transfert::query()->whereBetween('dateTransfert', [$debut, $fin])->get();
        }
        return view('transferts.report', compact('transferts', 'query', 'debut', 'fin', 'envoiOuagadougou', 'retraitOuagadougou', 'envoiLome', 'retraitLome', 'transfertEnAttente'));
    }

    public function retraitUniquement()
    {
        $nextId = DB::table('transferts')->max('id') + 1;
        $numeroDeTransfert = time() . '-' . $nextId;
        $transfertsOfDay = Transfert::query()->whereDate('dateTransfert', date('Y-m-d'))->get();
        $pendingTransfert = Transfert::query()
            ->where('transfertPar', '!=', \auth()->user()->id)
            ->where('confirmationRetrait', '=', '0')->get();
        $transferts = Transfert::all();

        $dailyStatsIncome = Transfert::query()
            ->selectRaw('hour(dateTransfert) AS heure, SUM(montantTransfert) AS montant')
            ->whereDate('dateTransfert', date('Y-m-d'))
            ->where('transfertPar', Auth::user()->id)
            ->groupByRaw('hour(dateTransfert)')
            ->get();

        $dailyStatsOutGoing = Transfert::query()
            ->selectRaw('hour(dateTransfert) AS heure, SUM(montantTransfert) AS montant')
            ->whereDate('dateTransfert', date('Y-m-d'))
            ->where('confirmationTransfertPar', Auth::user()->id)
            ->groupByRaw('hour(dateTransfert)')
            ->get();
        return view('transferts.retrait', compact('nextId', 'numeroDeTransfert', 'pendingTransfert', 'transfertsOfDay', 'transferts', 'dailyStatsIncome', 'dailyStatsOutGoing'));
    }
}
