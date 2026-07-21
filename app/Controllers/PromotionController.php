<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\PromotionModel;

class PromotionController extends BaseController
{
    public function index()
    {
        $model = new PromotionModel();
        $promotions = $model->findAllDetailed();

        return view('promotions/index', ['promotions' => $promotions]);
    }

    public function showForm($id = null)
    {
        $promotionModel = new PromotionModel();
        $promotion = null;

        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAllProprio();

        if ($id) {
            $promotion = $promotionModel->find($id);
            if (!$promotion) {
                return redirect()->to('/promotions')->with('error', 'Promotion non trouvée.');
            }
        }

        return view('promotions/form', ['promotion' => $promotion, 'operateurs' => $operateurs]);
    }

    public function save()
    {
        $promotionModel = new PromotionModel();

        $data = [
            'id' => $this->request->getPost('id'),
            'pct_promotion' => $this->request->getPost('pct_promotion'),
            'operateur_id' => $this->request->getPost('operateur_id')
        ];

        if (!$data['id']) {
            if (!$this->validateData($data, $promotionModel->insertRules, $promotionModel->insertMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        } else {
            if (!$this->validateData($data, $promotionModel->updateRules, $promotionModel->updateMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());  
            }
        }

        $promotionModel->save($data);

        return redirect()->to('/promotions')->with('success', 'Promotion enregistrée avec succès.');
    }

    public function delete($id)
    {
        $promotionModel = new PromotionModel();
        $commission = $promotionModel->find($id);

        if (!$commission) {
            return redirect()->to('/promotions')->with('error', 'Promotion non trouvée.');
        }

        $promotionModel->delete($id);
        return redirect()->to('/promotions')->with('success', 'Promotion supprimée avec succès.');
    }    
}