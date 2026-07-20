<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefixe', 'operateur_id'];

    public function getOperateurByNumero($numero)
    {
        $prefixe = substr($numero, 0, 3);
        return $this->where('prefixe', $prefixe)->first();
    }
}