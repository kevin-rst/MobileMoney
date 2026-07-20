<?php

namespace App\Controllers;

use App\Models\FraisModel;
use App\Models\TypeOperation;

class FraisController extends BaseController
{
    public function index()
    {
        $model = new FraisModel();
        $frais = $model->findAll();

        // Récupère les types d'opération pour afficher le libellé
        $typeModel = new TypeOperation();
        $types = $typeModel->findAll();
        $mapTypes = [];
        foreach ($types as $t) {
            $mapTypes[$t['id']] = $t['libelle'];
        }

        foreach ($frais as $k => $fr) {
            $frais[$k]['type_operation_libelle'] = $mapTypes[$fr['type_operation_id']] ?? '';
        }

        return view('frais/index', ['frais' => $frais]);
    }

    public function showForm($id = null)
    {
        $typeModel = new TypeOperation();
        $types = $typeModel->findAll();

        if ($id) {
            $model = new FraisModel();
            $frais = $model->find($id);

            if (!$frais) {
                return redirect()->to('/frais')->with('error', 'Frais non trouvé.');
            }

            return view('frais/form', ['frais' => $frais, 'types' => $types]);
        }

        return view('frais/form', ['types' => $types]);
    }

    public function save()
    {
        $model = new FraisModel();

        $data = [
            'id' => $this->request->getPost('id'),
            'montant_min' => $this->request->getPost('montant_min'),
            'montant_max' => $this->request->getPost('montant_max'),
            'frais' => $this->request->getPost('frais'),
            'type_operation_id' => $this->request->getPost('type_operation_id')
        ];

        if (!$model->montantsValid($data['montant_min'], $data['montant_max'])) {
            return redirect()->back()->withInput()->with('error', 'Le montant minimum doit être inférieur au montant maximum.');
        }

        if (!$model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/frais')->with('success', 'Frais enregistré avec succès.');
    }

    public function delete($id)
    {
        $model = new FraisModel();
        $frais = $model->find($id);

        if (!$frais) {
            return redirect()->to('/frais')->with('error', 'Frais non trouvé.');
        }

        $model->delete($id);
        return redirect()->to('/frais')->with('success', 'Frais supprimé avec succès.');
    }
}
