<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/form-pilih-jurusan', 'Home::formPilihJurusan');

$routes->group('master', function ($routes) {
    $routes->group('kriteria', ['namespace' => 'App\Controllers\Panel'], function ($routes) {
        $routes->get('', 'Kriteria::index', ['as' => 'data-kriteria']);
        $routes->get('add', 'Kriteria::add', ['as' => 'data-kriteria-add']);
        $routes->get('edit/(:num)', 'Kriteria::edit/$1', ['as' => 'data-kriteria-edit']);
    });
    $routes->group('kriteria', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('add', 'Kriteria::add', ['as' => 'data-kriteria-add']);
        $routes->post('edit/(:num)', 'Kriteria::edit/$1', ['as' => 'data-kriteria-edit']);
        $routes->get('delete/(:num)', 'Kriteria::delete/$1', ['as' => 'data-kriteria-delete']);
        $routes->post('save/sub/(:num)', 'Kriteria::saveSub/$1', ['as' => 'data-sub-kriteria-save']);
        $routes->post('delete/sub/(:num)', 'Kriteria::deleteSub/$1', ['as' => 'data-sub-kriteria-delete']);
        $routes->post('form', 'Kriteria::form', ['as' => 'data-kriteria-form']);
    });
    // Alternatif
    $routes->group('alternatif', ['namespace' => 'App\Controllers\Panel'], function ($routes) {
        $routes->get('', 'Alternatif::index', ['as' => 'data-alternatif']);
        $routes->get('add', 'Alternatif::add', ['as' => 'data-alternatif-add']);
        $routes->get('edit/(:num)', 'Alternatif::edit/$1', ['as' => 'data-alternatif-edit']);
    });
    $routes->group('alternatif', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('add', 'Alternatif::add', ['as' => 'data-alternatif-add']);
        $routes->post('edit/(:num)', 'Alternatif::edit/$1', ['as' => 'data-alternatif-edit']);
        $routes->get('delete/(:num)', 'Alternatif::delete/$1', ['as' => 'data-alternatif-delete']);
    });

    // Jurusan
    $routes->group('jurusan', ['namespace' => 'App\Controllers\Panel'], function ($routes) {
        $routes->get('', 'Jurusan::index', ['as' => 'data-jurusan']);
        $routes->get('add', 'Jurusan::add', ['as' => 'data-jurusan-add']);
        $routes->get('edit/(:num)', 'Jurusan::edit/$1', ['as' => 'data-jurusan-edit']);
    });
    $routes->group('jurusan', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('add', 'Jurusan::add', ['as' => 'data-jurusan-add']);
        $routes->post('edit/(:num)', 'Jurusan::edit/$1', ['as' => 'data-jurusan-edit']);
        $routes->get('delete/(:num)', 'Jurusan::delete/$1', ['as' => 'data-jurusan-delete']);
        $routes->post('form', 'Jurusan::form', ['as' => 'data-jurusan-form']);
        $routes->post('set', 'Jurusan::set', ['as' => 'data-jurusan-set']);
    });

    // manajemen User
    $routes->group('user', ['namespace' => 'App\Controllers\Panel'], function ($routes) {
        $routes->get('', 'User::index', ['as' => 'data-user']);
    });
    $routes->group('user', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('add', 'User::add', ['as' => 'data-user-add']);
        $routes->post('edit/(:num)', 'User::edit/$1', ['as' => 'data-user-edit']);
        $routes->post('form', 'User::form', ['as' => 'data-user-form']);
        $routes->get('delete/(:num)', 'User::delete/$1', ['as' => 'data-user-delete']);
    });
});
$routes->group('hitung', ['namespace' => 'App\Controllers\Panel'], function ($routes) {
    $routes->get('', 'Hitung::index', ['as' => 'hitung']);
});
$routes->group('hitung', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->post('content', 'Hitung::content', ['as' => 'hitung-content']);
    $routes->post('alternatif', 'Hitung::formAlternatif', ['as' => 'hitung-form-alternatif']);
    $routes->post('alternatif/(:num)', 'Hitung::alternatif/$1', ['as' => 'hitung-alternatif-save']);
    $routes->post('kriteria', 'Hitung::kriteria', ['as' => 'hitung-kriteria']);
    $routes->post('kriteria/(:num)', 'Hitung::kriteriaSub/$1', ['as' => 'hitung-subkriteria']);
    // reset
    $routes->get('reset', 'Hitung::reset', ['as' => 'hitung-reset']);
});



/*
 * Auth routes file.
 */
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Login/out
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');

    // Registration
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');

    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');
});

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