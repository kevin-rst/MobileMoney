<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'comptes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'solde', 'date_creation'];
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = '';

    public function findAllDetailed()
    {
        return $this->select('comptes.*, clients.nom as client_nom, clients.prenom as client_prenom, clients.numero_telephone as client_numero_telephone')
                    ->join('clients', 'comptes.client_id = clients.id', 'left')
                    ->findAll();
    }

    public function getTotalSolde()
    {
        return $this->selectSum('solde')->first();
    }
}