<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\OperateurModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $numero_telephone = $this->request->getPost('numero_telephone');

        $clientModel = new ClientModel();
        $operateurModel = new OperateurModel();
        $prefixeModel = new PrefixeModel();

        $data = [
            'numero_telephone' => $numero_telephone,
        ];

        if (!$this->validateData($data, $clientModel->loginRules, $clientModel->loginMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        
        $client = $clientModel->where('numero_telephone', $numero_telephone)->first();
        
        if ($client) {
            $operator = $prefixeModel->getOperateurByNumero($numero_telephone);
            if (!$operateurModel->isProprio($operator['id'])) {
                return redirect()->back()->withInput()->with('error', 'Numéro de téléphone ou code hors propriété de l\'opérateur.');
            }
        } 

        $operateur = $operateurModel->where('code', $numero_telephone)->first();
        if ($operateur && !$operateurModel->isProprio($operateur['id'])) {
            return redirect()->back()->withInput()->with('error', 'Numéro de téléphone ou code hors propriété de l\'opérateur.');
        }

        if ($client) {
            session()->set('client_id', $client['id']);
            session()->set('client_nom', $client['nom']);
            session()->set('client_prenom', $client['prenom']);
            session()->set('client_numero_telephone', $client['numero_telephone']);
            session()->set('role', 'client');

            return redirect()->to('/dashboard')->with('success', 'Connexion réussie en tant que client.');
        } elseif ($operateur) {
            session()->set('operateur_id', $operateur['id']);
            session()->set('operateur_nom', $operateur['nom']);
            session()->set('operateur_code', $operateur['code']);
            session()->set('role', 'operateur');

            return redirect()->to('/backoffice')->with('success', 'Connexion réussie en tant qu\'opérateur.');
        } else {
            return redirect()->back()->with('error', 'Numéro de téléphone ou code incorrect');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}