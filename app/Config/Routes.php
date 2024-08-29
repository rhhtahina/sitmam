<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/testdata', 'TestData::index');
// profil
$routes->get('/Profil', 'Profil::index');
$routes->get('/Profil/getAllProfil', 'Profil::getAllProfil');
$routes->post('/Profil/getAllProfil', 'Profil::getAllProfil');
$routes->get('/Profil/createProfil', 'Profil::createProfil');
$routes->post('/Profil/createProfil', 'Profil::createProfil');
$routes->post('/Profil/viewProfil', 'Profil::viewProfil');
$routes->post('/Profil/updateProfil', 'Profil::updateProfil');
$routes->post('/Profil/deleteProfil', 'Profil::deleteProfil');

// Utilisateur
$routes->get('/User', 'User::index');
$routes->post('/User/createUser', 'User::createUser');
$routes->post('/User/getAllUser', 'User::getAllUser');
