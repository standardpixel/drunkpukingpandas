<?
require_once '/var/www_libs/aws-sdk-for-php/sdk.class.php';

#
# Set up simple db instance
#

$sdb = new AmazonSDB();

#
# Get most recent drink
#

$response   = $sdb->select('SELECT * FROM `prod_drunkpukingpandas_drinks` limit 1');
$attributes = $response->body->SelectResult->Item->Attribute;

#
# Format date
#

$cocktail_date = strtotime($attributes[2]->Value);
$friday_date   = strtotime('next Friday');
$today_date    = strtotime('Today');
$unfriendly_date = date('M, d Y',$cocktail_date);

if($friday_date==$cocktail_date) {
	$friendly_date = 'This Friday';
} elseif($today_date==$cocktail_date) {
	$friendly_date = 'Today';
} else {
	$friendly_date = 'On:&nbsp;' . $unfriendly_date;
}

#
# Get other attribites
#

$drink_name       = (string) $attributes[0]->Value;
$barkeep_username = (string) $attributes[1]->Value;
$drink_url        = (string) $attributes[3]->Value;

?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name = "viewport" content = "user-scalable=no, width=device-width">
	<link rel="SHORTCUT ICON" href="fav.ico"/>
	<title>****r Saloon</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>

	<div class='body'>
		
		What are we drinking <?= $friendly_date ?>?
		
		<?if(count($drink_url)){?>
			<a href="<?= $drink_url ?>" class="hot">
		<?}?>
		
		<span class="hot"><?= $drink_name ?></span>
		
		<?if(count($drink_url)){?>
			</a>
		<?}?>
		
	</div>

	<div class='footer'>Barkeep: <?= $barkeep_username ?></div>
</body>
</html>