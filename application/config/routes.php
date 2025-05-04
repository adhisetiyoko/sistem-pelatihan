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

// Profile
$route['profile'] = 'profile';
$route['profile/edit'] = 'profile/edit';
$route['profile/change_password'] = 'profile/change_password';
$route['profile/activity_log'] = 'profile/activity_log';
$route['profile/update'] = 'profile/update';
$route['profile/update_password'] = 'profile/update_password';

// Settings
$route['settings'] = 'settings';
$route['settings/account'] = 'settings/account';
$route['settings/account/update'] = 'settings/account/update';
