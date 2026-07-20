<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'compte_source_id', 'compte_destination_id', 'montant', 'frais', 'date_operation'];

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
}