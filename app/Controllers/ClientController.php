<?php

namespace App\Controllers;
use App\Models\ClientModel;

class ClientController extends BaseController
{
    public function index()
    {
        return view('client/dashboard');
    }

    public function solde($clientId)
    {
        $clientModel = new ClientModel();
        $solde = $clientModel->getSoldeByClientId($clientId);
        $historique = $clientModel->getHistoriqueTransactions($clientId);

        return view('client/solde', ['solde' => $solde, 'historique' => $historique]);
    }
}