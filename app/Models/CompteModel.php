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
}