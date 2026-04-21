<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Routes
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Parkir Routes (Public)
$routes->get('parkir', 'Parkir::index');
$routes->post('parkir/create', 'Parkir::create');
$routes->get('parkir/scan/(:segment)', 'Parkir::scan/$1');
$routes->get('parkir/struk/(:segment)', 'Parkir::struk/$1');
$routes->get('parkir/pdf/(:segment)', 'Parkir::generatePDF/$1');

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('laporan', 'Admin::laporan');
    $routes->post('checkout/(:num)', 'Admin::checkout/$1');
    $routes->get('export-pdf', 'Admin::exportPDF');
    $routes->get('detail-transaksi/(:segment)', 'Admin::detailTransaksi/$1');
});