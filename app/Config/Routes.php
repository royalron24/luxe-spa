<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =========================
// Public pages
// =========================

$routes->get('/', 'PublicArea\\Pages::home');
$routes->get('/about', 'PublicArea\\Pages::about');
$routes->get('/facility', 'PublicArea\\Pages::facility');
$routes->get('/policy', 'PublicArea\\Pages::policy');
$routes->get('/book', 'PublicArea\\Pages::book');
$routes->post('/book/enquire', 'PublicArea\\Pages::bookEnquire');
$routes->get('/contact', 'PublicArea\\Pages::contact');
$routes->post('/contact/send', 'PublicArea\\Pages::contactSend');

// =========================
// Member pages
// =========================

$routes->get('/login', 'User\\MemberAuth::login');
$routes->get('/register', 'User\\MemberAuth::register');
$routes->post('/login/process', 'User\\MemberAuth::loginProcess');
$routes->post('/register/process', 'User\\MemberAuth::registerProcess');
$routes->get('/member/dashboard', 'User\\MemberAuth::dashboard');
$routes->get('/member/profile', 'User\\MemberAuth::profile');
$routes->post('/member/profile/update', 'User\\MemberAuth::updateProfile');
$routes->get('/member/subscription', 'User\\MemberAuth::subscription');
$routes->post('/member/subscription/pay', 'User\\MemberAuth::paySubscription');
$routes->get('/member/payment-history', 'User\\MemberAuth::paymentHistory');
$routes->get('/member/treatment-history', 'User\\MemberAuth::treatmentHistory');
$routes->get('/member/booking', 'User\\MemberAuth::booking');
$routes->post('/member/booking/store', 'User\\MemberAuth::bookingStore');
$routes->get('/member/booking/cancel/(:num)', 'User\\MemberAuth::bookingCancel/$1');
$routes->post('/member/payment/prepare', 'User\\MemberAuth::preparePayment');
$routes->get('/member/payment', 'User\\MemberAuth::showPayment');
$routes->post('/member/payment/process', 'User\\MemberAuth::processPayment');
$routes->get('/logout', 'User\\MemberAuth::logout');

// =========================
// Admin pages
// =========================

$routes->get('/admin', 'User\\MemberAuth::login');
$routes->get('/admin/login', 'User\\MemberAuth::login');
$routes->post('/admin/login/process', 'Admin\\Auth::login');
$routes->get('/admin/logout', 'Admin\\Auth::logout');

// =========================
// Dashboard
// =========================

$routes->get('/admin/dashboard', 'Admin\\Dashboard::index');
$routes->get('/admin/bookings', 'Admin\\Bookings::index');
$routes->post('/admin/bookings/status/(:num)', 'Admin\\Bookings::updateStatus/$1');
$routes->get('/admin/bookings/delete/(:num)', 'Admin\\Bookings::delete/$1');

// =========================
// Members
// =========================

$routes->get('/members', 'Admin\\Member::index');
$routes->get('/members/search', 'Admin\\Member::search');
$routes->get('/members/create', 'Admin\\Member::create');
$routes->post('/members/store', 'Admin\\Member::store');
$routes->get('/members/edit/(:num)', 'Admin\\Member::edit/$1');
$routes->post('/members/update/(:num)', 'Admin\\Member::update/$1');
$routes->get('/members/delete/(:num)', 'Admin\\Member::delete/$1');

// =========================
// Revenue
// =========================

$routes->get('/revenue', 'Admin\\Revenue::index');
$routes->get('/admin/revenue', 'Admin\\Revenue::index');

// =========================
// Filter
// =========================

$routes->get('/filter', 'Admin\\Filter::index');
$routes->get('/admin/filter', 'Admin\\Filter::index');

// =========================
// Staff
// =========================

$routes->get('/admin/staff', 'Admin\\Staff::index');
$routes->get('/admin/staff/create', 'Admin\\Staff::create');
$routes->post('/admin/staff/store', 'Admin\\Staff::store');
$routes->get('/admin/staff/edit/(:num)', 'Admin\\Staff::edit/$1');
$routes->post('/admin/staff/update/(:num)', 'Admin\\Staff::update/$1');
$routes->get('/admin/staff/delete/(:num)', 'Admin\\Staff::delete/$1');
