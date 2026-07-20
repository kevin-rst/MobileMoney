<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'id';
    protected $allowedFields = ['montant_min', 'montant_max', 'frais'];

    public function getFraisByMontant($montant, $typeOperationId)
    {
        return $this->where('montant_min <=', $montant)
                    ->where('montant_max >=', $montant)
                    ->where('type_operation_id', $typeOperationId)
                    ->first();
    }
}