<?
include('db.txt');
$cocktail_date = strtotime($db[0]['date']);
$friday_date   = strtotime('next Friday');
$today_date    = strtotime('Today')
//$message="I don't know. Ask Pancakes!";
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
<?if(stristr($_SERVER['HTTP_REFERER'],'techcrunch.com') || $_GET['forcetc']) {?>
	<center><object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/zq4A1uCQ1w0&amp;hl=en_US&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zq4A1uCQ1w0&hl=en_US&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object></center>
<?}elseif(!strlen($message)){?>
	<div class='body'>What are we drinking <?if($friday_date==$cocktail_date){?>This Friday<?}elseif($today_date==$cocktail_date){?>Today<?}else{?>On: <?=date('M, d Y',$cocktail_date)?><?}?>? <?if($db[0]['url']){?><a href="<?=$db[0]['url']?>" class="hot"><?}?><span class="hot"><?=$db[0]['title']?></span><?if($db[0]['url']){?></a><?}?></div>
<?}else{?>
	<div class='body'>What are we drinking <?if($friday_date==$cocktail_date){?>This Friday<?}elseif($today_date==$cocktail_date){?>Today<?}else{?>On: <?=date('M, d Y',$cocktail_date)?><?}?>? <span class="hot"><?=$message?></span></div>
<?}?>
<div class='footer'>Barkeep: <?=$db[0]['barkeep']?></div>
</body>
</html>