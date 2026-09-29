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

$routes->get('DataAir', 'DataAir::index');
$routes->post('DataAir/tambah', 'DataAir::tambah');
$routes->get('DataAir/hapus/(:num)', 'DataAir::hapus/$1');
$routes->get('DataAir/(:num)', 'DataAir::show/$1');      // ← ini yang penting
$routes->post('DataAir/simpan/(:num)', 'DataAir::simpan/$1');
$routes->get('DataAir/acc1/(:num)', 'DataAir::acc1/$1');
$routes->get('DataAir/acc2/(:num)', 'DataAir::acc2/$1');
$routes->get('DataAir/acc3/(:num)', 'DataAir::acc3/$1');
$routes->get('DataAir/acc4/(:num)', 'DataAir::acc4/$1');
$routes->get('DataAir/acc5/(:num)', 'DataAir::acc5/$1'); // ← tambah

// ===== MasterDataAir =====
$routes->get('MasterDataAir', 'MasterDataAir::index');
$routes->post('MasterDataAir/create', 'MasterDataAir::create');
$routes->post('MasterDataAir/edit/(:num)', 'MasterDataAir::edit/$1');
$routes->get('MasterDataAir/delete/(:num)', 'MasterDataAir::delete/$1');
 
// ===== FisikKimiaAir =====
$routes->get('FisikKimiaAir',                              'FisikKimiaAir::index');
$routes->post('FisikKimiaAir/tambah',                      'FisikKimiaAir::tambah');
$routes->post('FisikKimiaAir/update/(:num)',               'FisikKimiaAir::update/$1');
$routes->get('FisikKimiaAir/hapus/(:num)',                 'FisikKimiaAir::hapus/$1');
$routes->get('FisikKimiaAir/detail/(:num)',                'FisikKimiaAir::detail/$1');
$routes->post('FisikKimiaAir/simpan/(:num)',               'FisikKimiaAir::simpan/$1');
$routes->get('FisikKimiaAir/hapusOutlet/(:num)/(:num)',    'FisikKimiaAir::hapusOutlet/$1/$2');
$routes->get('FisikKimiaAir/acc1/(:num)',                  'FisikKimiaAir::acc1/$1');
$routes->get('FisikKimiaAir/acc2/(:num)',                  'FisikKimiaAir::acc2/$1');
$routes->get('FisikKimiaAir/acc3/(:num)',                  'FisikKimiaAir::acc3/$1');
$routes->get('FisikKimiaAir/acc4/(:num)',                  'FisikKimiaAir::acc4/$1');
$routes->get('FisikKimiaAir/acc5/(:num)',                  'FisikKimiaAir::acc5/$1');


$routes->get('MikroAir', 'MikroAir::index');
$routes->get('MikroAir/detail/(:num)', 'MikroAir::detail/$1');
$routes->post('MikroAir/simpan/(:num)', 'MikroAir::simpan/$1');
$routes->get('MikroAir/acc3/(:num)', 'MikroAir::acc3/$1');
$routes->get('MikroAir/acc4/(:num)', 'MikroAir::acc4/$1');
$routes->get('MikroAir/acc5/(:num)', 'MikroAir::acc5/$1');
$routes->get('DataAir/cetakPdf/(:num)', 'DataAir::cetakPdf/$1');
$routes->post('FisikKimiaAir/uploadScan/(:num)', 'FisikKimiaAir::uploadScan/$1');
$routes->get('FisikKimiaAir/hapusScan/(:num)', 'FisikKimiaAir::hapusScan/$1');



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
