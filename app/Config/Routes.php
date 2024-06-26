<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/testdata', 'TestData::index');
$routes->get('/Profil', 'Profil::index');
$routes->get('/Profil/addProfil', 'Profil::addProfil');
$routes->get('/User', 'User::index');
