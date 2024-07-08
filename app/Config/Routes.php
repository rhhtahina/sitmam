<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/testdata', 'TestData::index');
$routes->get('/Profil', 'Profil::index');
$routes->get('/Profil/createProfil', 'Profil::createProfil');
$routes->post('/Profil/createProfil', 'Profil::createProfil');
$routes->get('/User', 'User::index');
