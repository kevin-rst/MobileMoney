<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'compte_source_id', 'compte_destination_id', 'montant', 'frais', 'commission', 'date_operation'];

    protected $useTimestamps = true;

    protected $createdField = 'date_operation';
    protected $updatedField = '';

    public function getTotalFraisGroupedByType()
    {
        return $this->select('types_operation.libelle as type_operation, COALESCE(SUM(operations.frais), 0) as total_frais')
                    ->join('types_operation', 'operations.type_operation_id = types_operation.id', 'left')
                    ->groupBy('types_operation.id')
                    ->findAll();
    }

    public function getTotalFraisGroupedByMois()
    {
        return $this->select("strftime('%m', date_operation) as mois, COALESCE(SUM(frais), 0) as total_frais")
                    ->groupBy("strftime('%m', date_operation)")
                    ->findAll();
    }

    public function getTransferts()
    {
        return $this->select('operations.*, comptes_source.numero_telephone as source_numero_telephone, comptes_destination.numero_telephone as destination_numero_telephone')
                    ->join('comptes as comptes_source', 'operations.compte_source_id = comptes_source.id', 'left')
                    ->join('comptes as comptes_destination', 'operations.compte_destination_id = comptes_destination.id', 'left')
                    ->where('type_operation_id', 1) // Assuming 1 is the ID for transfer operations
                    ->findAll();
    }

    public function getMontantsParOperateur()
{
    return $this->select('operateurs.nom AS operateur, SUM(operations.montant) AS total_montant, SUM(operations.commission) AS total_commission')
                ->join('comptes', 'operations.compte_destination_id = comptes.id')
                ->join('clients', 'comptes.client_id = clients.id')
                ->join('prefixes', 'SUBSTR(clients.numero_telephone, 1, 3) = prefixes.prefixe')
                ->join('operateurs', 'prefixes.operateur_id = operateurs.id')
                ->where('operations.type_operation_id', 1)
                ->groupBy('operateurs.id')
                ->orderBy('operateurs.nom', 'ASC')
                ->findAll();
}
}