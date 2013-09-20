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

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['confirmation_id'] = 'home/confirm';
$route['member/login'] = 'home/login_page';
$route['search_category'] = 'home/search_by_category';
$route['search_iklan'] = 'home/search_iklan';
$route['iklan/premium']= 'home/view_iklan_premium';

$route['cara_daftar']= 'home/view_caradaftar';
$route['cara_upgrade']= 'home/view_caraupgrade';
$route['tips']= 'home/view_tipjubel';
$route['contact']= 'home/view_cs';
$route['terms']= 'home/view_terms';
$route['unscribe']= 'home/unscribe';



/* End of file routes.php */
/* Location: ./application/config/routes.php */