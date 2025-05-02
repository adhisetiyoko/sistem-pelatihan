<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login'] = 'auth';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard';
$route['dashboard/peserta'] = 'dashboard/peserta';
$route['dashboard/tambah_peserta'] = 'dashboard/tambah_peserta';
$route['dashboard/edit_peserta/(:num)'] = 'dashboard/edit_peserta/$1';
$route['dashboard/hapus_peserta/(:num)'] = 'dashboard/hapus_peserta/$1';
$route['dashboard/users'] = 'dashboard/users';