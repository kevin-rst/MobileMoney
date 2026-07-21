<?php 


namespace App\Models;

use CodeIgniter\Model;

class CompteEpargne extends Model
{
    protected $table = 'comptes_epargne';
    protected $primaryKey = 'id';
    protected $allowedFields = ['solde_epargne', 'compte_id'];

    public function findByIdCompte($compteId) 
    {
        return $this->where('compte_id', $compteId)->first();
    }
}