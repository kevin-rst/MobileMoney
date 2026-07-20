<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'frais';
    protected $primaryKey = 'id';
    protected $allowedFields = ['montant_min', 'montant_max', 'frais', 'type_operation_id'];

    protected $validationRules = [
        'montant_min' => 'required|greater_than_equal_to[0]',
        'montant_max' => 'required|greater_than_equal_to[0]',
        'frais' => 'required|greater_than_equal_to[0]',
        'type_operation_id' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'montant_min' => [
            'required' => 'Le montant minimum est requis.',
            'greater_than_equal_to' => 'Le montant minimum doit être supérieur ou égal à 0.',
        ],
        'montant_max' => [
            'required' => 'Le montant maximum est requis.',
            'greater_than_equal_to' => 'Le montant maximum doit être supérieur ou égal à 0.',
        ],
        'frais' => [
            'required' => 'Le frais est requis.',
            'greater_than_equal_to' => 'Le frais doit être supérieur ou égal à 0.',
        ],
        'type_operation_id' => [
            'required' => "Le type d'opération est requis.",
            'is_natural_no_zero' => "Le type d'opération doit être valide.",
        ],
    ];

    public function montantsValid($montant_min, $montant_max)
    {
        return $montant_min < $montant_max;
    }
}