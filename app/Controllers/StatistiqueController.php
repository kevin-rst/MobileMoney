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

        $mois = [
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        ];

        foreach ($totalByMois as &$item) {
            $item['mois'] = $mois[$item['mois']];
        }

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