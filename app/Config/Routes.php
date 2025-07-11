<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('login', 'UserController::login');
$routes->post('register','UserController::register');
$routes->get('network/(:segment)', 'UserController::getNetwork/$1');
$routes->post('withdraw/(:num)','BalanceLogsController::withdraw/$1');
$routes->get('user/(:num)','BalanceLogsController::detailsaldo/$1');
$routes->options('(:any)', 'CorsController::preflight');