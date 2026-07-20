<?php 


namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operateur_id', 'pct_commission'];

}