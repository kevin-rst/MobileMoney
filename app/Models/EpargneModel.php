<?php 


namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargnes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'pct_epargne'];

    public function findByIdClient($clientId) 
    {
        return $this->where('client_id', $clientId)->first();
    }
}