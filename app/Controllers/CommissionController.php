<?php

namespace App\Controllers;

use App\Models\CommissionModel;
use App\Models\OperateurModel;

class CommissionController extends BaseController
{
    public function index()
    {
        $commissionModel = new CommissionModel();
        $commissions = $commissionModel->findAllDetailed();

        return view('commissions/index', ['commissions' => $commissions]);
    }

    public function showForm($id = null)
    {
        $commissionModel = new CommissionModel();
        $commission = null;

        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAllHorsProprio();

        if ($id) {
            $commission = $commissionModel->find($id);
            if (!$commission) {
                return redirect()->to('/commissions')->with('error', 'Commission non trouvée.');
            }
        }

        return view('commissions/form', ['commission' => $commission, 'operateurs' => $operateurs]);
    }

    public function save()
    {
        $commissionModel = new CommissionModel();

        $data = [
            'id' => $this->request->getPost('id'),
            'pct_commission' => $this->request->getPost('pct_commission'),
            'operateur_id' => $this->request->getPost('operateur_id')
        ];

        if (!$data['id']) {
            if (!$this->validateData($data, $commissionModel->insertRules, $commissionModel->insertMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if (!$this->validateData($data, $commissionModel->updateRules, $commissionModel->updateMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());  
            }
        }

        $commissionModel->save($data);

        return redirect()->to('/commissions')->with('success', 'Commission enregistrée avec succès.');
    }

    public function delete($id)
    {
        $commissionModel = new CommissionModel();
        $commission = $commissionModel->find($id);

        if (!$commission) {
            return redirect()->to('/commissions')->with('error', 'Commission non trouvée.');
        }

        $commissionModel->delete($id);
        return redirect()->to('/commissions')->with('success', 'Commission supprimée avec succès.');
    }
}