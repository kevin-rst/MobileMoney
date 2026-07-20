<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model 
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'numero_telephone'];

    public function getSoldeByClientId($clientId) 
    {
        $builder = $this->db->table('comptes');
        return $builder->select('solde')->where('client_id', $clientId)->get()->getRow()->solde;
    }

    public function getHistoriqueTransactions($clientId)
    {
        // dd($this->db->database);
        $builder = $this->db->table(('historique_details'));
        return $builder->where('compte_source_id', $clientId)->orWhere('compte_destination_id', $clientId)->orderBy('date_operation', 'DESC')->get()->getResult();
    }

    public function findByNumeroTelephone($numeroTelephone)
    {
        return $this->where('numero_telephone', $numeroTelephone)->first();
    }
}