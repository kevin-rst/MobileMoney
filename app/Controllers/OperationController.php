<?php

namespace App\Controllers;
use App\Models\TypeOperation;
use App\Models\CompteModel;
use App\Models\ClientModel;
use App\Models\FraisModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;

class OperationController extends BaseController
{
    public function showOperationsForm()
    {
        $typeOperationModel = new TypeOperation();
        $types = $typeOperationModel->findAll();

        return view('client/transaction-form', ['types' => $types]);
    }

    public function getMontantAPayer()
    {
        $montant = $this->request->getGet('montant');
        $numero = $this->request->getGet('numero');
        $typeOperationId = $this->request->getGet('type_operation_id');

        $operateurModel = new OperateurModel();
        $clientModel = new ClientModel();
        $fraisModel = new FraisModel();

        $prefix = $clientModel->isProprio($numero);
        $proprietaire = $operateurModel->find($prefix['operateur_id']);
        $frais = $fraisModel->getFraisByMontant($montant, $typeOperationId);

        dd($frais);

        if (!$frais) {
            $frais['frais'] = 0;
        }
        
        if ( !$proprietaire['proprio'] ) {
            $commission = $operateurModel->getOperateurCommission($proprietaire['id']);
            $commissionAmount = $montant * $commission;
            $totalAmount = $montant + $commissionAmount + $frais['frais'];
            return $this->response->setJSON(['montant_a_payer' => $totalAmount, 'commission' => $commissionAmount, 'frais' => $frais['frais']]);
        }

        return $this->response->setJSON(['montant_a_payer' => $montant + $frais['frais'], 'commission' => 0, 'frais' => $frais['frais']]);
    }

    public function processTransaction()
    {
        $compteModel = new CompteModel();
        $clientModel = new ClientModel();
        $fraisModel = new FraisModel();

        $data = $this->request->getPost();
        $compte_source = null;
        $compte_destination = null;
        
        // 1->transfert, 2->retrait, 3->depot

        if ($data['type_operation'] == 2) {
            $compte_source = $compteModel->getCompteByClientId(session()->get('client_id'));
        } elseif($data['type_operation'] == 1) {
            $compte_source = $compteModel->getCompteByClientId(session()->get('client_id'));
            $client_destination = $clientModel->findByNumeroTelephone($data['compte_destination']);
            $compte_destination = $compteModel->getCompteByClientId($client_destination['id']);

            if (!$compte_destination) {
                return redirect()->back()->withInput()->with('error', 'Le compte destinataire n\'existe pas.');
            }

        } else {
            $compte_destination = $compteModel->getCompteByClientId(session()->get('client_id'));
        }

        $operateurModel = new OperateurModel();
        $prefixeModel = new PrefixeModel();

        $prefixe = $prefixeModel->getOperateurByNumero(session()->get('client_numero_telephone'));
        
        $frais = $fraisModel->getFraisByMontant($data['montant'], $data['type_operation']);

        if (!$frais) {
            $frais['frais'] = 0;
        }

        $operationModel = new OperationModel();
        $operationData = [
            'type_operation_id' => $data['type_operation'],
            'compte_source_id' => $compte_source ? $compte_source['id'] : null,
            'compte_destination_id' => $compte_destination ? $compte_destination['id'] : null,
            'montant' => $data['montant'],
            'frais' => $frais ? $frais['frais'] : 0,
            'commission' => 0,
        ];

        if ($prefixe) {
            $operateurCible = $operateurModel->find($prefixe['operateur_id']);
        }
        
        if($data['type_operation'] == 1) {
            if ($compte_source['solde'] < $data['montant'] + $frais['frais']) {
                return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour effectuer cette transaction.');
            }

            $prefixeDestination = $prefixeModel->getOperateurByNumero($data['compte_destination']);
            $operateurDestination = $operateurModel->find($prefixeDestination['operateur_id']);

            if ($operateurDestination['proprio']) {
                $commissionAmount = 0;
            } else {
                $commission = $operateurModel->getOperateurCommission($operateurDestination['id']);
                $commissionAmount = $data['montant'] * $commission;
            }

            $operationData['commission'] = $commissionAmount;
            $operationData['montant'] = $data['montant'] + $frais['frais'];

            $compteModel->update($compte_source['id'], ['solde' => $compte_source['solde'] - ($data['montant'] + $frais['frais'] + $commissionAmount)]);
            $compteModel->update($compte_destination['id'], ['solde' => $compte_destination['solde'] + $data['montant'] + $frais['frais']]);

            if ($prefixe) {
                $operateurModel->update($prefixe['operateur_id'], ['gain' => $operateurCible['gain'] + $frais['frais']]);
            }

        } elseif($data['type_operation'] == 2) {
            if ($compte_source['solde'] < $data['montant'] + $frais['frais']) {
                return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour effectuer cette transaction.');
            }

            $compteModel->update($compte_source['id'], ['solde' => $compte_source['solde'] - $data['montant'] - $frais['frais']]);

            if ($prefixe) {
                $operateurModel->update($prefixe['operateur_id'], ['gain' => $operateurCible['gain'] + $frais['frais']]);
            }

        } else {
            $compteModel->update($compte_destination['id'], ['solde' => $compte_destination['solde'] + $data['montant']]);
        }

        if ($operationModel->insert($operationData)) {
            return redirect()->to(base_url('client/solde/' . session()->get('client_id')))->with('success', 'Transaction effectuée avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la transaction. Veuillez réessayer.');
        }
    }
}