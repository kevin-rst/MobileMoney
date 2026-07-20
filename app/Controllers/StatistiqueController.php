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

    public function montant()
    {
        $operationModel = new OperationModel();
        $montantParOperateur = $operationModel->getMontantsParOperateur();

        $totalMontant = array_reduce($montantParOperateur, function ($carry, $item) {
            return $carry + $item['total_montant'];
        }, 0);

        $totalCommission = array_reduce($montantParOperateur, function ($carry, $item) {
            return $carry + $item['total_commission'];
        }, 0);

        return view('statistiques/operateurs/montant', ['montantParOperateur' => $montantParOperateur, 'totalMontant' => $totalMontant, 'totalCommission' => $totalCommission]);
    }
}