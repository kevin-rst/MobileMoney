<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\PrefixeModel;

class PrefixeController extends BaseController 
{
    public function index()
    {
        $model = new PrefixeModel();
        $prefixes = $model->findAllDetailed();

        return view('prefixes/index', ['prefixes' => $prefixes]);
    }

    public function showForm($id = null)
    {
        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAll();

        if ($id) {
            $model = new PrefixeModel();
            $prefixe = $model->find($id);

            if (!$prefixe) {
                return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé.');
            }

            return view('prefixes/form', ['operateurs' => $operateurs, 'prefixe' => $prefixe]);
        }

        return view('prefixes/form', ['operateurs' => $operateurs]);
    }

    public function save()
    {
        $model = new PrefixeModel();

        $data = [
            'id' => $this->request->getPost('id'),
            'prefixe' => $this->request->getPost('prefixe'),
            'operateur_id' => $this->request->getPost('operateur_id')
        ];

        if (!$model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/prefixes')->with('success', 'Préfixe enregistré avec succès.');
    }

    public function delete($id)
    {
        $model = new PrefixeModel();
        $prefixe = $model->find($id);

        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe non trouvé.');
        }

        $model->delete($id);
        return redirect()->to('/prefixes')->with('success', 'Préfixe supprimé avec succès.');
    }
}