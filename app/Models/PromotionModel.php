<?php


namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pct_promotion', 'operateur_id'];

    protected $insertRules = [
        'operateur_id' => 'required|is_unique[promotions.operateur_id]',
        'pct_promotion' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1]'
    ];

    protected $updateRules = [
        'operateur_id' => 'required',
        'pct_promotion' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1]'
    ];

    protected $insertMessages = [
        'operateur_id' => [
            'required' => "L'identifiant de l'opérateur est requis.",
            'is_unique' => "Une commission pour cet opérateur existe déjà."
        ],
        'pct_promotion' => [
            'required' => 'Le pourcentage de commission est requis.',
            'numeric' => 'Le pourcentage de commission doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de commission doit être supérieur ou égal à 0.',
            'less_than_equal_to' => 'Le pourcentage de commission doit être inférieur ou égal à 1.'
        ]
    ];

    protected $updateMessages = [
        'operateur_id' => [
            'required' => "L'identifiant de l'opérateur est requis."
        ],
        'pct_promotion' => [
            'required' => 'Le pourcentage de commission est requis.',
            'numeric' => 'Le pourcentage de commission doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de commission doit être supérieur ou égal à 0.',
            'less_than_equal_to' => 'Le pourcentage de commission doit être inférieur ou égal à 1.'
        ]
    ];

    public function findByOperateurId($operateurId) {
        return $this->where('operateur_id', $operateurId)->first();
    }


    public function findAllDetailed()
    {
        return $this->select('promotions.*, operateurs.nom as operateur_nom, operateurs.code as operateur_code, operateurs.proprio as operateur_proprio')
                    ->join('operateurs', 'promotions.operateur_id = operateurs.id', 'left')
                    ->findAll();
    }
}