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
	<style>
		body{background-color:#000;color:#0063DC;font-size:200%;font-family:Arial, sans-serif;}
		.hot{color:#FF0084;white-space:nowrap;text-decoration:none;}
		.hot:hover{text-shadow: 0 0 0.2em #87F}
		div.body{height:20%;position:absolute;top:40%;right:10px;bottom:40%;left:10px;}
		div.footer{font-size:50%;position:absolute;bottom:10px;left:10px;}
		
		.possibly-mobile body{background-color:font-size:100%;}
		.possibly-mobile div.body{height:100%;position:absolute;top:10px;right:10px;bottom:10px;left:10px;}
		.possibly-mobile span.hot{overflow: hidden;
		text-overflow: ellipsis;
		-o-text-overflow: ellipsis;
		white-space: nowrap;
		width: 100%;display:block;}
		.possibly-mobile div.footer{display:none;}
    	</style>
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