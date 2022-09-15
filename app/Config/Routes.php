<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/*$routes->get('user', 'Client::index');
$routes->get('user', 'Client::index');
$routes->post('user', 'Client::store');
$routes->get('user/(:num)', 'Client::show/$1');
$routes->post('user/(:num)', 'Client::update/$1');
$routes->delete('user/(:num)', 'Client::destroy/$1');

$routes->get('servicios', 'Client::servicios');
$routes->get('imagenes', 'Client::imagenes');
$routes->get('anfitriones', 'Client::anfitriones');
$routes->get('municipio', 'Client::municipio');
$routes->get('tarifas', 'Client::tarifas');
$routes->get('tipoHospedajes', 'Client::tipoHospedajes');

$routes->get('paises', 'Client::paises');
$routes->get('departamentos/(:num)', 'Client::departamentos/$1');
$routes->get('municipios/(:num)', 'Client::municipios/$1');*/

$routes->resource('usuarios');
$routes->post('login', 'Auth::login');
$routes->post('registrar', 'Auth::register');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}