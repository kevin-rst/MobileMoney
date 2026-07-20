<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation_id', 'compte_source_id', 'compte_destination_id', 'montant', 'frais', 'date_operation'];

    protected $useTimestamps = true;

    protected $createdField = 'date_operation';
    protected $updatedField = '';

}