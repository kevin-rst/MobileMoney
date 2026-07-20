<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'ClientController::index');

$routes->group('client', function($routes) {
    $routes->get('solde/(:num)', 'ClientController::solde/$1');

    $routes->get('operations', 'OperationController::showOperationsForm');

    $routes->post('transaction', 'OperationController::processTransaction');
});
