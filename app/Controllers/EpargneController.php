<?php

namespace App\Controllers;

use App\Models\EpargneModel;

class EpargneController extends BaseController
{
    public function showForm()
    {
        return view('epargne/form');
    }

    public function saveEpargne()
    {
        $epargneModel = new EpargneModel();

        $data = $this->request->getPost();
        $clientId = session()->get('client_id');

        $result = [
            'pct_epargne' => $data['pct_epargne'],
            'client_id' => $clientId,
        ];

        $epargneModel->insert($result);

        return redirect()->to(base_url('client/solde/' . session()->get('client_id')));
    }
}