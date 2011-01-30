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
	
	require_once '/var/www_libs/aws-sdk-for-php/sdk.class.php';
	$sdb = new AmazonSDB();
	$blessed_auth_response      = $sdb->get_attributes('prod_drunkpukingpandas','blessed',$auth_response->children[1]->children[5]->attributes['nsid']);
	$blessed_auth_response_nsid = (string) $blessed_auth_response->body->GetAttributesResult->Attribute->Name;
	
	if(!$blessed_auth_response_nsid) {
		#
		# Not blessed
		#
		
		$auth_response = 0;
		
		$auth_write = 'Tell Eric to grant you access.';
	}
}

if((!$_COOKIE['auth_token'] || !$auth_response) && !$auth_write) {
	$auth_write = '<a href="' . $api->getAuthUrl('read') . '">Psssst... What\'s the password?</a>';
}



?>