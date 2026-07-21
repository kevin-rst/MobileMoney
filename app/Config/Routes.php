<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->post('/logout', 'AuthController::logout');

$routes->get('/backoffice', 'Home::index', ['filter' => 'role:operateur']);

$routes->group('prefixes', ['filter' => 'role:operateur'], function ($routes) {
    $routes->get('', 'PrefixeController::index');
    $routes->get('showForm', 'PrefixeController::showForm');
    $routes->get('showForm/(:num)', 'PrefixeController::showForm/$1');
    $routes->post('save', 'PrefixeController::save');
    $routes->get('delete/(:num)', 'PrefixeController::delete/$1');
});

$routes->group('frais', ['filter' => 'role:operateur'], function ($routes) {
    $routes->get('', 'FraisController::index');
    $routes->get('showForm', 'FraisController::showForm');
    $routes->get('showForm/(:num)', 'FraisController::showForm/$1');
    $routes->post('save', 'FraisController::save');
    $routes->get('delete/(:num)', 'FraisController::delete/$1');
});

$routes->group('commissions', ['filter' => 'role:operateur'], function ($routes) {
    $routes->get('', 'CommissionController::index');
    $routes->get('showForm', 'CommissionController::showForm');
    $routes->get('showForm/(:num)', 'CommissionController::showForm/$1');
    $routes->post('save', 'CommissionController::save');
    $routes->get('delete/(:num)', 'CommissionController::delete/$1');
});

$routes->group('promotions', ['filter' => 'role:operateur'], function ($routes) {
    $routes->get('', 'PromotionController::index');
    $routes->get('showForm', 'PromotionController::showForm');
    $routes->get('showForm/(:num)', 'PromotionController::showForm/$1');
    $routes->post('save', 'PromotionController::save');
    $routes->get('delete/(:num)', 'PromotionController::delete/$1');
});

$routes->group('statistiques', ['filter' => 'role:operateur'], function ($routes) {
    $routes->get('operateurs/gain', 'StatistiqueController::gain');
    $routes->get('operateurs/montant', 'StatistiqueController::montant');
    $routes->get('clients/solde', 'StatistiqueController::solde');
});


$routes->get('/dashboard', 'ClientController::index', ['filter' => 'role:client']);


$routes->group('epargne', ['filter' => 'role:client'], function($routes) {
    $routes->get('showForm', 'EpargneController::showForm');
    $routes->post('inserer', 'EpargneController::saveEpargne');
});

$routes->group('client', ['filter' => 'role:client'], function($routes) {
    $routes->get('solde/(:num)', 'ClientController::solde/$1');

    $routes->get('operations', 'OperationController::showOperationsForm');

    $routes->post('transaction', 'OperationController::processTransaction');

    $routes->get('transaction/montant-a-payer', 'OperationController::getMontantAPayer');
});