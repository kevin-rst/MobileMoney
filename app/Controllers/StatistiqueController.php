<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;

class StatistiqueController extends BaseController
{
    public function gain()
    {
        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAll();

        $gainTotal = $operateurModel->getGainTotal();

        $operationModel = new OperationModel();

        $totalByType = $operationModel->getTotalFraisGroupedByType();
        $totalByMois = $operationModel->getTotalFraisGroupedByMois();

        return view('statistiques/operateurs/gain', ['operateurs' => $operateurs, 'gainTotal' => $gainTotal, 'totalByType' => $totalByType, 'totalByMois' => $totalByMois]);
    }

    public function solde()
    {
        $compteModel = new CompteModel();
        $comptes = $compteModel->findAllDetailed();

        $soldeTotal = $compteModel->getTotalSolde();

        return view('statistiques/clients/solde', ['comptes' => $comptes, 'soldeTotal' => $soldeTotal]);
    }
}