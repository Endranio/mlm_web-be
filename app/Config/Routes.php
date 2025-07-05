<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('login', 'UserController::login');
$routes->post('register','UserController::register');
$routes->get('network/(:segment)', 'UserController::getNetwork/$1');
$routes->post('withdraw/(:num)','WithdrawController::withdraw/$1');