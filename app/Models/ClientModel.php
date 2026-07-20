<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model 
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'numero_telephone'];

    protected $loginRules = [
        'numero_telephone' => 'required',
    ];

    protected $loginMessages = [
        'numero_telephone' => [
            'required' => 'Le numéro de téléphone est requis.',
        ],
    ];
}