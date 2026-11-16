<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('about', 'Site::page/about');
$routes->get('services', 'Site::services');
$routes->get('projects', 'Site::projects');
$routes->get('projects/(:segment)', 'Site::project/$1');
$routes->get('news', 'Site::news');
$routes->get('news/(:segment)', 'Site::article/$1');
$routes->get('contact', 'Site::contact');
$routes->post('contact', 'Site::sendContact');

$routes->group('admin', static function ($routes) {
    $routes->get('login', 'Admin\\AuthController::login');
    $routes->post('login', 'Admin\\AuthController::attempt');
    $routes->post('logout', 'Admin\\AuthController::logout', ['filter' => 'auth']);
    $routes->get('/', 'Admin\\DashboardController::index', ['filter' => 'auth']);

    $routes->get('pages', 'Admin\\PagesController::index', ['filter' => 'auth']);
    $routes->get('pages/new', 'Admin\\PagesController::form', ['filter' => 'auth']);
    $routes->get('pages/(:num)/edit', 'Admin\\PagesController::form/$1', ['filter' => 'auth']);
    $routes->post('pages/save', 'Admin\\PagesController::save', ['filter' => 'auth']);
    $routes->post('pages/(:num)/delete', 'Admin\\PagesController::delete/$1', ['filter' => 'auth']);

    $routes->get('content', 'Admin\\ContentController::index', ['filter' => 'auth']);
    $routes->get('content/new', 'Admin\\ContentController::form', ['filter' => 'auth']);
    $routes->get('content/(:num)/edit', 'Admin\\ContentController::form/$1', ['filter' => 'auth']);
    $routes->post('content/save', 'Admin\\ContentController::save', ['filter' => 'auth']);
    $routes->post('content/(:num)/delete', 'Admin\\ContentController::delete/$1', ['filter' => 'auth']);

    $routes->get('media', 'Admin\\MediaController::index', ['filter' => 'auth']);
    $routes->post('media', 'Admin\\MediaController::upload', ['filter' => 'auth']);
    $routes->post('media/(:num)/delete', 'Admin\\MediaController::delete/$1', ['filter' => 'auth']);

    $routes->get('inquiries', 'Admin\\InquiriesController::index', ['filter' => 'auth']);
    $routes->post('inquiries/(:num)/status', 'Admin\\InquiriesController::status/$1', ['filter' => 'auth']);
    $routes->get('profile', 'Admin\\ProfileController::edit', ['filter' => 'auth']);
    $routes->post('profile/password', 'Admin\\ProfileController::password', ['filter' => 'auth']);
});

// Additional CMS pages can be published at their slug.
$routes->get('(:segment)', 'Site::page/$1');
