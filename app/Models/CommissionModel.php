<?php 


namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operateur_id', 'pct_commission'];

    protected $insertRules = [
        'operateur_id' => 'required|is_unique[commissions.operateur_id]',
        'pct_commission' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1]'
    ];

    protected $updateRules = [
        'operateur_id' => 'required',
        'pct_commission' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[1]'
    ];

    protected $insertMessages = [
        'operateur_id' => [
            'required' => "L'identifiant de l'opérateur est requis.",
            'is_unique' => "Une commission pour cet opérateur existe déjà."
        ],
        'pct_commission' => [
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
        'pct_commission' => [
            'required' => 'Le pourcentage de commission est requis.',
            'numeric' => 'Le pourcentage de commission doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de commission doit être supérieur ou égal à 0.',
            'less_than_equal_to' => 'Le pourcentage de commission doit être inférieur ou égal à 1.'
        ]
    ];

    public function findAllDetailed()
    {
        return $this->select('commissions.*, operateurs.nom as operateur_nom, operateurs.code as operateur_code, operateurs.proprio as operateur_proprio')
                    ->join('operateurs', 'commissions.operateur_id = operateurs.id', 'left')
                    ->findAll();
    }
}