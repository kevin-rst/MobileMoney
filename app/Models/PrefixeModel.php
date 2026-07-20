<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefixe', 'operateur_id'];

    protected $validationRules = [
        'prefixe' => 'required|is_unique[prefixes.prefixe]|exact_length[3]|regex_match[/^0\d{2}$/]',
        'operateur_id' => 'required'
    ];

    protected $validationMessages = [
        'prefixe' => [
            'required' => 'Le champ préfixe est requis.',
            'is_unique' => 'Ce préfixe existe déjà.',
            'exact_length' => 'Le préfixe doit contenir exactement 3 chiffres.',
            'regex_match' => 'Le préfixe doit commencer par 0 suivi de 2 chiffres.'
        ],
        'operateur_id' => [
            'required' => "L'identifiant de l'opérateur est requis."
        ]
    ];

    public function findAllDetailed()
    {
        return $this->select('prefixes.*, operateurs.nom as operateur_nom')
                    ->join('operateurs', 'operateurs.id = prefixes.operateur_id')
                    ->findAll();
    }

      public function getOperateurByNumero($numero)
    {
        $prefixe = substr($numero, 0, 3);
        return $this->where('prefixe', $prefixe)->first();
    }
}