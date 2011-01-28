<?
include('db.txt');
$cocktail_date = strtotime($db[0]['date']);
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
		
		<?if($db[0]['url']){?>
			<a href="<?=$db[0]['url']?>" class="hot">
		<?}?>
		
		<span class="hot"><?=$db[0]['title']?></span>
		
		<?if($db[0]['url']){?>
			</a>
		<?}?>
		
	</div>

	<div class='footer'>Barkeep: <?=$db[0]['barkeep']?></div>
</body>
</html>