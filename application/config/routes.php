<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'user/index';
$route['404_override'] = '';

/*admin*/
$route['admin'] = 'user/index';
$route['admin/signup'] = 'user/signup';
$route['admin/create_member'] = 'user/create_member';
$route['admin/login'] = 'user/index';
$route['admin/logout'] = 'user/logout';
$route['admin/login/validate_credentials'] = 'user/validate_credentials';

$route['admin/user_list'] = 'user/list_users';
$route['admin/user_list/add'] = 'user/create_member';
$route['admin/user_list/update'] = 'user/update';
$route['admin/user_list/email_header'] = 'user/email_header';
$route['admin/user_list/email_header/(:any)'] = 'user/email_header/$1';
$route['admin/user_list/update/(:any)'] = 'user/update/$1';
$route['admin/user_list/delete/(:any)'] = 'user/delete/$1';
$route['admin/user_list/(:any)'] = 'user/list_users/$1'; //$1 = page number

$route['admin/affiliate_code'] = 'user/affiliate_code'; //$1 = page number

$route['admin/get_html'] = 'user/scrap_url_data';
$route['admin/send_html'] = 'user/send_email';

$route['admin/sites'] = 'sites/index';
$route['admin/site/add'] = 'sites/add_site';
$route['admin/site/save_site'] = 'sites/save_site';
$route['admin/site/update_save_site'] = 'sites/update_save_site';
$route['admin/site/update'] = 'sites/update_site';
$route['admin/sites/update/(:any)'] = 'sites/update_site/$1';
$route['admin/sites/delete/(:any)'] = 'sites/delete/$1';
$route['admin/sites/(:any)'] = 'user/index/$1'; //$1 = page number

$route['admin/site/patterns'] = 'sites/pattern';
$route['admin/site/patterns/(:any)'] = 'sites/pattern/$1';
$route['admin/site/add_pattern'] = 'sites/add_pattern';
$route['admin/site/add_pattern/(:any)'] = 'sites/add_pattern/$1';
$route['admin/site/save_pattern'] = 'sites/save_pattern';
$route['admin/site/update_save_pattern'] = 'sites/update_save_pattern';
$route['admin/site/update_pattern'] = 'sites/update_pattern';
$route['admin/site/update_pattern/(:any)'] = 'sites/update_pattern/$1';
$route['admin/site/delete_pattern/(:any)'] = 'sites/delete_pattern/$1';

$route['admin/site/scrap/(:any)'] = 'sites/page_scrap_form/$1';
/* End of file routes.php */
/* Location: ./application/config/routes.php */