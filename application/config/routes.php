<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['dashboard'] = 'home/dashboard';
$route['sign_out'] = 'home/sign_out';
$route['login'] = 'home';
$route['admin'] = 'home/profil_admin';
$route['profil'] = 'home/profil_pegawai';
$route['password'] = 'home/ganti_password';

//route data barang
$route['barang'] = 'data_barang/index';
$route['tambah_barang'] = 'data_barang/tambah_data';
$route['edit_barang'] = 'data_barang/edit_data';
$route['edit_barang/(:any)'] = 'data_barang/edit_data/$1';
$route['stok_barang'] = 'data_barang/stok';
$route['ajax_barang'] = 'data_barang/ajax_barang';
$route['ajax_stok_barang'] = 'data_barang/ajax_stok_barang';

//route data pegawai
$route['pegawai'] = 'data_pegawai/index';
$route['pegawai/(:any)'] = 'data_pegawai/detail_pegawai/$1';
$route['tambah_pegawai'] = 'data_pegawai/tambah_pegawai';
$route['edit_pegawai'] = 'data_pegawai/edit_data';
$route['edit_pegawai/(:any)'] = 'data_pegawai/edit_data/$1';
$route['ganti_password'] = 'data_pegawai/ganti_password';
$route['ajax_pegawai'] = 'data_pegawai/ajax_pegawai';

//route data supplier
$route['supplier'] = 'data_supplier/index';
$route['supplier/(:any)'] = 'data_supplier/edit_supplier/$1';
$route['ajax_supplier'] = 'data_supplier/ajax_supplier';
$route['tambah_supplier'] = 'data_supplier/tambah_supplier';
$route['hapus_supplier'] = 'data_supplier/hapus_data';

//route data pib
$route['data_pib'] = 'pembelian/pib';
$route['tambah_pib'] = 'pembelian/tambah_pib';
$route['data_pib/(:any)'] = 'pembelian/detail_pib/$1';
$route['edit_pib/(:any)'] = 'pembelian/update_pib/$1';
$route['hapus_pib'] = 'pembelian/hapus_data_pib';
$route['ajax_pib'] = 'pembelian/ajax_pib';

//route data pembelian barang
$route['data_pembelian'] = 'pembelian/index';
$route['tambah_pembelian'] = 'pembelian/tambah_data';
$route['hapus_pembelian'] = 'pembelian/hapus_data';
$route['data_pembelian/(:any)'] = 'pembelian/detail_pembelian/$1';
$route['edit_pembelian'] = 'pembelian/edit_pembelian';
$route['edit_pembelian/(:any)'] = 'pembelian/edit_pembelian/$1';
$route['tambah_cart'] = 'pembelian/tambah_cart';
$route['get_item'] = 'pembelian/get_item';
$route['update_cart'] = 'pembelian/update_cart';
$route['remove_item'] = 'pembelian/remove_item';
$route['ajax_pembelian'] = 'pembelian/ajax_pembelian';

//route data produksi proses
$route['produksi_proses'] = 'produksi/index';
$route['ajax_produksi_proses'] = 'produksi/ajax_produksi_proses';
$route['data_produksi_proses/(:any)'] = 'produksi/detail_produksi_proses/$1';
$route['hapus_produksi_proses'] = 'produksi/hapus_data';
$route['tambah_produksi_proses'] = 'produksi/tambah_data';
$route['tambah_cart_produksi_proses'] = 'produksi/tambah_cart_produksi_proses';
$route['get_item_produksi_proses'] = 'produksi/get_item_produksi_proses';
$route['get_item_produksi_proses/(:any)'] = 'produksi/get_item_produksi_proses/$1';
$route['update_cart_produksi_proses'] = 'produksi/update_cart_produksi_proses';
$route['hapus_item_produksi_proses'] = 'produksi/hapus_cart_produksi_proses';
$route['edit_produksi_proses/(:any)'] = 'produksi/edit_produksi_proses/$1';

//route data hasil produksi
$route['produksi_hasil'] = 'produksi_hasil/index';
$route['ajax_produksi_hasil'] = 'produksi_hasil/ajax_produksi_hasil';
$route['data_produksi_hasil/(:any)'] = 'produksi_hasil/detail_produksi_hasil/$1';
$route['hapus_produksi_hasil'] = 'produksi_hasil/hapus_data';
$route['tambah_produksi_hasil'] = 'produksi_hasil/tambah_data';
$route['tambah_cart_produksi_hasil'] = 'produksi_hasil/tambah_cart_produksi_hasil';
$route['get_item_produksi_hasil'] = 'produksi_hasil/get_item_produksi_hasil';
$route['get_item_produksi_hasil/(:any)'] = 'produksi_hasil/get_item_produksi_hasil/$1';
$route['update_cart_produksi_hasil'] = 'produksi_hasil/update_cart_produksi_hasil';
$route['hapus_item_produksi_hasil'] = 'produksi_hasil/hapus_cart_produksi_hasil';
$route['edit_produksi_hasil/(:any)'] = 'produksi_hasil/edit_produksi_hasil/$1';

//route data sampah produksi
$route['produksi_sampah'] = 'produksi_sampah/index';
$route['ajax_produksi_sampah'] = 'produksi_sampah/ajax_produksi_sampah';
$route['data_produksi_sampah/(:any)'] = 'produksi_sampah/detail_produksi_sampah/$1';
$route['hapus_produksi_sampah'] = 'produksi_sampah/hapus_data';
$route['tambah_produksi_sampah'] = 'produksi_sampah/tambah_data';
$route['tambah_cart_produksi_sampah'] = 'produksi_sampah/tambah_cart_produksi_sampah';
$route['get_item_produksi_sampah'] = 'produksi_sampah/get_item_produksi_sampah';
$route['get_item_produksi_sampah/(:any)'] = 'produksi_sampah/get_item_produksi_sampah/$1';
$route['update_cart_produksi_sampah'] = 'produksi_sampah/update_cart_produksi_sampah';
$route['hapus_item_produksi_sampah'] = 'produksi_sampah/hapus_cart_produksi_sampah';
$route['edit_produksi_sampah/(:any)'] = 'produksi_sampah/edit_produksi_sampah/$1';

//route data peb
$route['data_peb'] = 'penjualan/peb';
$route['tambah_peb'] = 'penjualan/tambah_peb';
$route['data_peb/(:any)'] = 'penjualan/detail_peb/$1';
$route['edit_peb/(:any)'] = 'penjualan/update_peb/$1';
$route['hapus_peb'] = 'penjualan/hapus_data_peb';
$route['ajax_peb'] = 'penjualan/ajax_peb';

//route data penjualan barang
$route['data_penjualan'] = 'penjualan/index';
$route['data_penjualan/(:any)'] = 'penjualan/detail_penjualan/$1';
$route['tambah_penjualan'] = 'penjualan/tambah_data';
$route['ajax_penjualan'] = 'penjualan/ajax_penjualan';
$route['cari_barang_penjualan'] = 'penjualan/cari_barang_penjualan';
$route['tambah_cart_penjualan'] = 'penjualan/tambah_cart_penjualan';
$route['hapus_item_penjualan'] = 'penjualan/hapus_cart_penjualan';
$route['get_item_penjualan'] = 'penjualan/get_item_penjualan';
$route['get_item_penjualan/(:any)'] = 'penjualan/get_item_penjualan/$1';
$route['update_cart_penjualan'] = 'penjualan/update_cart_penjualan';
$route['hapus_penjualan'] = 'penjualan/hapus_penjualan';
$route['edit_penjualan'] = 'penjualan/edit_penjualan';
$route['edit_penjualan/(:any)'] = 'penjualan/edit_penjualan/$1';

//route data laporan
$route['stok_harian'] = 'laporan/data_stok_harian';
$route['stok_harian/(:any)'] = 'laporan/ajax_data_stok_harian/$1';
$route['stok_harian/(:any)/(:any)/(:any)'] = 'laporan/cetak_stok_harian/$1/$2/$3';
$route['stok_bulanan'] = 'laporan/data_stok_bulanan';
$route['stok_bulanan/(:any)'] = 'laporan/cetak_stok_bulanan/$1';
$route['stok_tahunan'] = 'laporan/data_stok_tahunan';
$route['stok_tahunan/(:any)'] = 'laporan/cetak_stok_tahunan/$1';
$route['pembelian_harian'] = 'laporan/data_pembelian_harian';
$route['pembelian_harian/(:any)'] = 'laporan/cetak_pembelian_harian/$1';
$route['pembelian_bulanan'] = 'laporan/data_pembelian_bulanan';
$route['pembelian_bulanan/(:any)'] = 'laporan/cetak_pembelian_bulanan/$1';
$route['penjualan_harian'] = 'laporan/data_penjualan_harian';
$route['penjualan_harian/(:any)'] = 'laporan/cetak_penjualan_harian/$1';
$route['penjualan_bulanan'] = 'laporan/data_penjualan_bulanan';
$route['penjualan_bulanan/(:any)'] = 'laporan/cetak_penjualan_bulanan/$1';

$route['ajax_stok_harian'] = 'laporan/ajax_data_stok_harian';
$route['ajax_stok_harian/(:any)'] = 'laporan/ajax_data_stok_harian/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
