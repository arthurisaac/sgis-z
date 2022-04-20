<?php

namespace App\Http\Controllers\api;

use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Models\Transfert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomEmetteur' => 'required',
            'nomBeneficiaire' => 'required',
            'numeroDocumentEmetteur' => 'required',
            'typeTransfert' => 'required',
            'montantTransfert' => 'required',
            'fraisTransfert' => 'required',
            'transfertPar' => 'required',
        ]);

        $transfert = new Transfert([
            'numeroTransfert' => $request->get('numeroTransfert'),
            'nomEmetteur' => $request->get('nomEmetteur'),
            'nomBeneficiaire' => $request->get('nomBeneficiaire'),
            'typeDocumentEmetteur' => $request->get('typeDocumentEmetteur'),
            'numeroDocumentEmetteur' => $request->get('numeroDocumentEmetteur'),
            'codeTransfert' => $request->get('codeTransfert'),
            'typeTransfert' => $request->get('typeTransfert'),
            'montantTransfert' => $request->get('montantTransfert'),
            'fraisTransfert' => $request->get('fraisTransfert'),
            'transfertPar' => $request->get('transfertPar'),
        ]);
        $transfert->save();
        event(new MyEvent('Transfert'));
        return \response()->json(["success" => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'typeDocumentBeneficiaire' => 'required',
            'numeroDocumentBeneficiaire' => 'required',
        ]);

        $transfert = Transfert::query()->find($id);
        $transfert->confirmationRetrait = 1;
        $transfert->typeDocumentBeneficiaire = $request->get('typeDocumentBeneficiaire');
        $transfert->numeroDocumentBeneficiaire = $request->get('numeroDocumentBeneficiaire');
        $transfert->dateConfirmationRetrait = date('Y-m-d H:i:s');
        $transfert->confirmationTransfertPar = $request->get('confirmationTransfertPar');
        $transfert->save();

        return \response()->json(["message" => "Confirmé avec suucès", "success" => "success", "transfert" => $transfert]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = Transfert::query()->find($id);
        if ($data) $data->delete();
        return response()->json([
            'success' => 'success'
        ]);
    }
}
