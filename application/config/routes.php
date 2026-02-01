
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin routes
$route['admin/dashboard'] = 'admin/Dashboard';
$route['admin/dashboard/(:any)'] = 'admin/Dashboard/$1';
$route['admin/user/tambah'] = 'admin/User/tambah';
$route['admin/user/simpan'] = 'admin/User/simpan';
$route['admin/user/edit/(:num)'] = 'admin/User/edit/$1';
$route['admin/user/update/(:num)'] = 'admin/User/update/$1';
$route['admin/user/hapus/(:num)'] = 'admin/User/hapus/$1';
$route['admin/user'] = 'admin/User';
$route['admin/user/(:any)'] = 'admin/User/$1';
$route['admin/user/(:any)/(:any)'] = 'admin/User/$1/$2';
$route['admin/tarif'] = 'admin/Tarif';
$route['admin/tarif/(:any)'] = 'admin/Tarif/$1';
$route['admin/tarif/(:any)/(:any)'] = 'admin/Tarif/$1/$2';
$route['admin/area'] = 'admin/area/index';
$route['admin/area/tambah'] = 'admin/area/tambah';
$route['admin/area/simpan'] = 'admin/area/simpan';

// Petugas routes
$route['petugas/transaksi'] = 'petugas/Transaksi/index';
$route['petugas/transaksi/simpan'] = 'petugas/Transaksi/simpan';
$route['petugas/transaksi/detail/(:num)'] = 'petugas/Transaksi/detail/$1';
$route['petugas/transaksi/cetak/(:num)'] = 'petugas/Transaksi/cetak/$1';

// Owner routes
$route['owner/laporan'] = 'owner/Laporan/laporan';
$route['owner/laporan/cetak'] = 'owner/Laporan/cetak';