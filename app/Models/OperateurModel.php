<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'code', 'gain', 'proprio'];

    public function getGainTotal()
    {
        return $this->selectSum('gain')->first();
    }

    public function isProprio($operateurId)
    {
        $operateur = $this->find($operateurId);
        return $operateur && $operateur['proprio'] == 1;
    }

    public function findAllHorsProprio()
    {
        return $this->where('proprio', 0)->findAll();
    }
public function getOperateurCommission($operateurId)
    {
        $commission = $this->db->table('commissions')
            ->where('operateur_id', $operateurId)
            ->get()
            ->getRow();

        return $commission ? $commission->pct_commission : 0;
    }

}