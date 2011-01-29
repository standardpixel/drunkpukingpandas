<?
require_once '../php/pear/Flickr/API.php';
require_once '../php/config.inc';

#
# Instantiate Flickr_API
$api =& new Flickr_API($config);

#
# Logout
#
if($_GET['logout']) {
	setcookie('auth_token',0);
	header('Location: /');
}

#
# Is drunk puking pandas blessed by this user yet?
#

if($_GET['frob']) {
	
	#
	# Get auth status
	#
	
	$auth_status = $api->callMethod('flickr.auth.getToken', array(
		'frob' => $_GET['frob']
	));
	
	if($auth_status) {
		setcookie('auth_token',(string) $auth_status->children[1]->children[1]->content);
	}
	
	header('Location: /');
	
}

if($_COOKIE['auth_token']) {
	$auth_response = $api->callMethod('flickr.auth.checkToken', array(
		'auth_token' => $_COOKIE['auth_token']
	));
} 

if(!$_COOKIE['auth_token'] || !$auth_response) {
	$auth_write = '<a href="' . $api->getAuthUrl('read') . '">Login</a>';
}



?>