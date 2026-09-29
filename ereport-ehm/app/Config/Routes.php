<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// $routes->get('/', 'PdfController::index');

$routes->match(['get', 'post'], 'PdfController/htmlToPDF', 'PdfController::htmlToPDF');
$routes->get('/', 'Home::index', ['filter' => 'authFilter']);
$routes->get('/swab', 'Home::Swab');

$routes->get('/DataPpoj', 'DataPpoj::index', ['filter' => 'authFilter']);
$routes->get('/Suhu', 'Suhu::index', ['filter' => 'authFilter']);
$routes->get('/Rh', 'Rh::index', ['filter' => 'authFilter']);
$routes->get('/Flow', 'Flow::index', ['filter' => 'authFilter']);
$routes->get('/Partikel', 'Partikel::index', ['filter' => 'authFilter']);
$routes->get('/Lux', 'Lux::index', ['filter' => 'authFilter']);
//$routes->get('/', 'Home::index');
//$routes->get('/Home', 'Home::index');
$routes->get('Ruangan', 'Ruangan::index');
$routes->get('Login', 'Auth::Login');
$routes->get('Register', 'Auth::Register');
$routes->post('Register/Process', 'Auth::Process_Register');
$routes->get('Logout', 'Auth::Logout');
//$routes->post('Auth', 'Auth::Process_Login');

$routes->post('ambil_ahu', 'DataPpoj::Ambil_Ahu');
$routes->post('ambil_ruangan', 'Suhu::Ambil_Ruangan');
$routes->get('Dashboard', 'Home::dashboard');
//$routes->get('/DataPpojSwab', 'DataPpojSwab::index', ['filter' => 'authFilter']);
$routes->get('DataPpojSwab', 'DataPpojSwab::index');
$route['DataPpojSwab/getDetailAlat'] = 'DataPpojSwab/getDetailAlat';
$routes->post('ambil_namamesin', 'DataPpojSwab::Ambil_NamaMesin');
$routes->get('/dashboard', 'SwabController::dashboard');
$routes->get('/masterdataswab', 'MasterDataSwab::index');
$routes->post('/masterdataswab/create', 'MasterDataSwab::create');
$routes->post('/masterdataswab/update/(:num)', 'MasterDataSwab::update/$1');
$routes->get('/masterdataswab/delete/(:num)', 'MasterDataSwab::delete/$1');
$routes->get('/oospenyimpangan/tampil-oos/(:num)', 'OosPenyimpangan::TampilOOS/$1');
$routes->get('/oospenyimpangan/tampil-penyimpangan/(:num)', 'OosPenyimpangan::TampilPenyimpangan/$1');
$routes->get('/export_swab/excel', 'ExportSwab::excel');
$routes->get('suhu/getSyaratSuhu', 'Suhu::getSyaratSuhu');
$routes->get('UserManagement/delete/(:num)', 'UserManagement::delete/$1');











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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
