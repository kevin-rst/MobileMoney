<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface 
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('client_id') || !$session->get('operateur_id')) {
            return redirect()->to('/')->with('error', 'Vous devez être connecté d\'abord.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}