<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('/', 'Auth::login');

// Auth Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::authenticate');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::doRegister');
    $routes->get('logout', 'Auth::logout');
    $routes->get('reset-password', 'Auth::resetPassword');
    $routes->post('reset-password', 'Auth::resetPassword');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
});

// Admin Routes
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Users management
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->get('users/toggle/(:num)', 'Admin\Users::toggle/$1');

    // Books management
    $routes->get('books', 'Admin\Books::index');
    $routes->get('books/create', 'Admin\Books::create');
    $routes->post('books/store', 'Admin\Books::store');
    $routes->get('books/edit/(:num)', 'Admin\Books::edit/$1');
    $routes->post('books/update/(:num)', 'Admin\Books::update/$1');
    $routes->get('books/delete/(:num)', 'Admin\Books::delete/$1'); // Menggunakan GET untuk kompatibilitas
    $routes->delete('books/delete/(:num)', 'Admin\Books::delete/$1'); // Support DELETE method juga

    // Borrowings management
    $routes->get('borrowings', 'Admin\Borrowings::index');
    $routes->get('borrowings/create', 'Admin\Borrowings::create');
    $routes->post('borrowings/store', 'Admin\Borrowings::store');
    $routes->get('borrowings/show/(:num)', 'Admin\Borrowings::show/$1');
    $routes->post('borrowings/return/(:num)', 'Admin\Borrowings::return/$1');
    $routes->get('borrowings/overdue', 'Admin\Borrowings::overdue');
    $routes->get('borrowings/updateOverdue', 'Admin\Borrowings::updateOverdue');
    $routes->get('borrowings/report', 'Admin\Borrowings::report');

    // Reports
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/borrowings', 'Admin\Reports::borrowings');
    $routes->get('reports/books', 'Admin\Reports::books');
    $routes->get('reports/exportBorrowings', 'Admin\Reports::exportBorrowings');
    $routes->get('reports/exportBooks', 'Admin\Reports::exportBooks');

    // Admin Profile
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/password', 'Admin\Profile::password');
});

// User Routes
$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'User\Dashboard::index'); // Tambahkan rute untuk halaman utama user
    $routes->get('dashboard', 'User\Dashboard::index');
    
    // Books
    $routes->group('books', function ($routes) {
        $routes->get('/', 'User\Books::index');
        $routes->get('(:num)', 'User\Books::show/$1'); // Mengubah 'view' menjadi langsung ID
        $routes->post('borrow/(:num)', 'User\Books::borrow/$1');
        $routes->get('borrow/(:num)', 'User\Books::show/$1'); // Tambahkan kembali rute GET untuk penanganan yang lebih baik
    }); // Close the 'books' group here

    // Borrowings
    $routes->group('borrowings', function ($routes) {
        $routes->get('/', 'User\Borrowings::index');
        $routes->get('history', 'User\Borrowings::history');
        $routes->get('extend/(:num)', 'User\Borrowings::index'); // Redirect GET to index
        $routes->post('extend/(:num)', 'User\Borrowings::extend/$1');
        $routes->get('return/(:num)', 'User\Borrowings::index'); // Redirect GET to index
        $routes->post('return/(:num)', 'User\Borrowings::return/$1');
    });

    // Profile
    $routes->get('profile', 'User\Profile::index');
    $routes->post('profile/update', 'User\Profile::update');
    $routes->post('profile/password', 'User\Profile::password');
}); // Close the 'user' group here
