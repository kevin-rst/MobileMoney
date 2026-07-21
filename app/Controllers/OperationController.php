<?php

namespace App\Controllers;
use App\Models\TypeOperation;
use App\Models\CompteModel;
use App\Models\ClientModel;
use App\Models\FraisModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;
use App\Models\PromotionModel;

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
        $typeOperationId = $this->request->getGet('type_operation');
        $destinations = $this->request->getGet('destinations');
        $numero = $this->request->getGet('numero');

        $fraisModel = new FraisModel();
        $prefixeModel = new PrefixeModel();
        $operateurModel = new OperateurModel();

        $compteCount = 1;
        $rawDestinations = [];

        if ($destinations && $numero) {
            return $this->response->setJSON(['montant_a_payer' => 0, 'error' => 'Veuillez fournir au moins un numéro.']);
        }

        if (!empty($destinations)) {
            $rawDestinations = preg_split('/[\r\n,;]+/', trim($destinations));
        } elseif (!empty($numero)) {
            $rawDestinations[] = trim($numero);
        }


        $compteCount = count(array_filter($rawDestinations, static function ($value) {
            return trim($value) !== '';
        }));

        $recipientOperators = [];
        foreach ($rawDestinations as $recipientNumero) {
            $prefixeDestination = $prefixeModel->getOperateurByNumero($recipientNumero);
            if (!$prefixeDestination) {
                return $this->response->setJSON(['montant_a_payer' => 0, 'error' => 'Opérateur non trouvé pour le numéro: ' . $recipientNumero]);
            }
            $recipientOperators[] = $prefixeDestination['operateur_id'];
        }

        if (count(array_unique($recipientOperators)) > 1) {
            return $this->response->setJSON(['montant_a_payer' => 0, 'error' => 'Les destinataires doivent appartenir au même opérateur.']);
        }
         
        $prefixe = $prefixeModel->getOperateurByNumero($rawDestinations[0] ?? $numero);
        $operateur = $operateurModel->find($prefixe['operateur_id'] ?? null);
        $commission = $operateur ? $operateurModel->getOperateurCommission($operateur['id']) : 0;
        $commissionAmount = $commission * ($montant / max(1, $compteCount));

        $frais = $fraisModel->getFraisByMontant($montant / max(1, $compteCount), $typeOperationId);
        $fraisRetrait = $fraisModel->getFraisByMontant($montant / max(1, $compteCount), 2);

        if (!$frais) {
            $frais['frais'] = 0;
        }

        if (!$fraisRetrait) {
            $fraisRetrait['frais'] = 0;
        }

        return $this->response->setJSON(['montant_a_payer' => (($montant / max(1, $compteCount)) + $frais['frais'] + $fraisRetrait['frais'] + $commissionAmount) * max(1, $compteCount), 'success' => 'Montant calculé avec succès.']);
    }

    public function processTransaction()
    {
        $compteModel = new CompteModel();
        $clientModel = new ClientModel();
        $fraisModel = new FraisModel();
        $operateurModel = new OperateurModel();
        $prefixeModel = new PrefixeModel();
        $operationModel = new OperationModel();
        $promotionModel = new PromotionModel();

        $data = $this->request->getPost();

        $include_frais = $data['frais'] ?? 0;
        $typeOperation = (int) ($data['type_operation'] ?? 0);

        $compteSource = null;
        $compteDestination = null;

        if ($typeOperation === 2) {
            $compteSource = $compteModel->getCompteByClientId(session()->get('client_id'));
        } elseif ($typeOperation === 1) {
            $compteSource = $compteModel->getCompteByClientId(session()->get('client_id'));
        } else {
            $compteDestination = $compteModel->getCompteByClientId(session()->get('client_id'));
        }

        if ($typeOperation !== 3 && (!$compteSource || !isset($compteSource['id']))) {
            return redirect()->back()->withInput()->with('error', 'Compte source introuvable.');
        }

        if ($typeOperation === 3 && (!$compteDestination || !isset($compteDestination['id']))) {
            return redirect()->back()->withInput()->with('error', 'Compte destinataire introuvable.');
        }

        $prefixe = $prefixeModel->getOperateurByNumero(session()->get('client_numero_telephone'));
        $operateurCible = $prefixe ? $operateurModel->find($prefixe['operateur_id']) : null;

        if ($typeOperation === 1) {
            $recipients = [];
            if (!empty($data['compte_destinations'])) {
                $rawRecipients = preg_split('/[\r\n,;]+/', trim($data['compte_destinations']));
                foreach ($rawRecipients as $recipient) {
                    $recipient = trim($recipient);
                    if ($recipient !== '') {
                        $recipients[] = $recipient;
                    }
                }
            } elseif (!empty($data['compte_destination'])) {
                $recipients[] = trim($data['compte_destination']);
            }

            if (empty($recipients)) {
                return redirect()->back()->withInput()->with('error', 'Veuillez renseigner au moins un numéro destinataire.');
            }

            $recipientOperators = [];
            foreach ($recipients as $recipientNumero) {
                $prefixeDestination = $prefixeModel->getOperateurByNumero($recipientNumero);
                if (!$prefixeDestination) {
                    return redirect()->back()->withInput()->with('error', 'Le numéro destinataire n\'est pas reconnu : ' . $recipientNumero);
                }
                $recipientOperators[] = $prefixeDestination['operateur_id'];
            }

            if (count(array_unique($recipientOperators)) > 1) {
                return redirect()->back()->withInput()->with('error', 'Tous les numéros destinataires doivent appartenir au même opérateur.');
            }

            $splitAmounts = $this->splitMontantEquitable((float) $data['montant'], count($recipients));
            $totalNeeded = 0;
            $recipientData = [];

            foreach ($recipients as $index => $recipientNumero) {
                $clientDestination = $clientModel->findByNumeroTelephone($recipientNumero);
                if (!$clientDestination) {
                    return redirect()->back()->withInput()->with('error', 'Le compte destinataire n\'existe pas pour le numéro : ' . $recipientNumero);
                }

                $compteDestinationItem = $compteModel->getCompteByClientId($clientDestination['id']);
                if (!$compteDestinationItem) {
                    return redirect()->back()->withInput()->with('error', 'Le compte destinataire n\'existe pas pour le numéro : ' . $recipientNumero);
                }

                $shareAmount = (float) $splitAmounts[$index];
                $frais = $fraisModel->getFraisByMontant($shareAmount, $typeOperation);
                $fraisRetrait = $fraisModel->getFraisByMontant($shareAmount, 2);

                if (!$frais) {
                    $frais = ['frais' => 0];
                }

                if (!$fraisRetrait) {
                    $fraisRetrait = ['frais' => 0];
                }

                $prefixeDestination = $prefixeModel->getOperateurByNumero($recipientNumero);
                $operateurDestination = $operateurModel->find($prefixeDestination['operateur_id']);
                $commission = $operateurModel->getOperateurCommission($operateurDestination['id']);
                $commissionAmount = $shareAmount * $commission;

                if ($operateurCible['id'] == $operateurDestination['id']) {
                    $promotion = $promotionModel->findByOperateurId($operateurCible['id'])['pct_promotion'];
                    $frais['frais'] = $frais['frais'] - ($frais['frais'] * $promotion);
                }

                $montant = $shareAmount;
                if ($include_frais == 0) {
                    if ($montant < $fraisRetrait['frais']) {
                        return redirect()->back()->withInput()->with('error', 'Le montant pour le numéro ' . $recipientNumero . ' est inférieur aux frais de retrait.');
                    }
                    $montant -= $fraisRetrait['frais'];
                }

                $recipientData[] = [
                    'numero' => $recipientNumero,
                    'compte_destination' => $compteDestinationItem,
                    'montant' => $montant ,
                    'frais' => $frais['frais'],
                    'frais_retrait' => $fraisRetrait['frais'],
                    'commission' => $commissionAmount,
                ];

                $totalNeeded += $montant + $frais['frais'] + $commissionAmount;
            }

            if ($compteSource['solde'] < $totalNeeded) {
                return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour effectuer cette transaction.');
            }

            foreach ($recipientData as $detail) {
                $updatedSourceBalance = $compteSource['solde'] - $detail['montant'] - $detail['frais'] - $detail['frais_retrait'] - $detail['commission'];
                $updatedDestinationBalance = $detail['compte_destination']['solde'] + $detail['montant'] + $detail['frais_retrait'];

                $compteModel->update($compteSource['id'], ['solde' => $updatedSourceBalance]);
                $compteModel->update($detail['compte_destination']['id'], ['solde' => $updatedDestinationBalance]);

                $compteSource['solde'] = $updatedSourceBalance;
                $detail['compte_destination']['solde'] = $updatedDestinationBalance;

                if ($operateurCible) {
                    $operateurCible['gain'] = $operateurCible['gain'] + $detail['frais'];
                    $operateurModel->update($operateurCible['id'], ['gain' => $operateurCible['gain']]);
                }

                $operationModel->insert([
                    'type_operation_id' => $typeOperation,
                    'compte_source_id' => $compteSource['id'],
                    'compte_destination_id' => $detail['compte_destination']['id'],
                    'montant' => $detail['montant'] + $detail['frais'] + $detail['commission'] + $detail['frais_retrait'],
                    'frais' => $detail['frais'],
                    'commission' => $detail['commission'],
                ]);
            }

            return redirect()->to(base_url('client/solde/' . session()->get('client_id')))->with('success', 'Transaction effectuée avec succès.');
        }

        if ($typeOperation === 2) {
            $frais = $fraisModel->getFraisByMontant($data['montant'], $typeOperation);
            if (!$frais) {
                $frais = ['frais' => 0];
            }

            if ($compteSource['solde'] < $data['montant'] + $frais['frais']) {
                return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour effectuer cette transaction.');
            }

            $updatedSourceBalance = $compteSource['solde'] - $data['montant'] - $frais['frais'];
            $compteModel->update($compteSource['id'], ['solde' => $updatedSourceBalance]);

            if ($operateurCible) {
                $operateurCible['gain'] = $operateurCible['gain'] + $frais['frais'];
                $operateurModel->update($operateurCible['id'], ['gain' => $operateurCible['gain']]);
            }

            $operationModel->insert([
                'type_operation_id' => $typeOperation,
                'compte_source_id' => $compteSource['id'],
                'compte_destination_id' => null,
                'montant' => $data['montant'] + $frais['frais'],
                'frais' => $frais['frais'],
                'commission' => 0,
            ]);

            return redirect()->to(base_url('client/solde/' . session()->get('client_id')))->with('success', 'Transaction effectuée avec succès.');
        }

        $frais = $fraisModel->getFraisByMontant($data['montant'], $typeOperation);
        if (!$frais) {
            $frais = ['frais' => 0];
        }

        $updatedDestinationBalance = $compteDestination['solde'] + $data['montant'];
        $compteModel->update($compteDestination['id'], ['solde' => $updatedDestinationBalance]);

        $operationModel->insert([
            'type_operation_id' => $typeOperation,
            'compte_source_id' => null,
            'compte_destination_id' => $compteDestination['id'],
            'montant' => $data['montant'],
            'frais' => $frais['frais'],
            'commission' => 0,
        ]);

        return redirect()->to(base_url('client/solde/' . session()->get('client_id')))->with('success', 'Transaction effectuée avec succès.');
    }

    private function splitMontantEquitable(float $montant, int $nombreDestinataires): array
    {
        if ($nombreDestinataires <= 0) {
            return [];
        }

        $parts = [];
        $baseAmount = round($montant / $nombreDestinataires, 2);
        $remainder = round($montant - ($baseAmount * $nombreDestinataires), 2);

        for ($i = 0; $i < $nombreDestinataires; $i++) {
            $value = $baseAmount;
            if ($i === $nombreDestinataires - 1) {
                $value = round($value + $remainder, 2);
            }
            $parts[] = $value;
        }

        return $parts;
    }
}