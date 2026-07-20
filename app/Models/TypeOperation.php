<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperation extends Model
{
    protected $table = 'types_operation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];

}