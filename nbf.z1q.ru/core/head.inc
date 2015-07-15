<head>
	 
	<?php 
	$cat = $_GET['cat'];
	if($cat =='1') { echo "<title>Доставка суши - BigFish</title>"; } 
		elseif($cat =='2') { include ('catalog/items/cat-2.inc'); } 
		elseif($cat =='3') { echo "<title>Доставка сашими - BigFish</title>"; }
		elseif($cat =='4') { echo "<title>Доставка салатов - BigFish</title>"; }
		elseif($cat =='5') { echo "<title>Горячие блюда, на дом доставка крылешек - BigFish</title>"; }
		elseif($cat =='6') { echo "<title>Десерты японской кухни - BigFish</title>"; }
		elseif($cat =='7') { echo "<title>Сеты, асорти сеты, доставка на дом - BigFish</title>"; }
		elseif($cat =='8') { echo "<title>Дополнительные ингридиенты, соусы - BigFish</title>"; }
		elseif($cat =='9') { echo "<title>Доставка напитков, соки - BigFish</title>"; }
		elseif($cat =='10') { echo "<title>el'Grande пицца. Доставка пиццы домой или в офис - BigFish</title>"; }
		elseif($cat =='11') { echo "<title>Суп мисо, ланчи в офис доставка - BigFish</title>"; }
		else { echo "<title>Доставка суши и ролов, доставка пиццы - Big-Fish</title>"; }
	?>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<meta http-equiv="Cache-Control" content="public" content="max-age=7200, must-revalidate" />
	<meta name="description" content="Круглосуточная доставка суши, роллов, пиццы, лапши и блюд восточной кухни на дом - BIG-FISH - (495) 970 00 00" /> 
	<meta name="keywords" content="" />
	<link href="/favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="/style/main.css" rel="stylesheet" type="text/css" media="all" />
	<script src="/style/jquery.js" type="text/javascript"></script>
	<script src="/style/jquery.maskedinput-1.3.js" type="text/javascript"></script>
	<script src="/style/functions.js" type="text/javascript"></script>
	
	<meta property="og:title" content="Круглосуточная доставка суши, роллов и блюд восточной кухни на дом - BIG-FISH - (495) 970 00 00"/>
        <meta property="og:type" content="food"/>
        <meta property="og:locality" content="Moscow, Russia"/>
        <meta property="og:country-name" content="Russia"/>
        <meta property="og:phone_number" content="+7 (495) 9700000"/>

        <meta property="og:image" content="http://big-fish.su/images/logo.jpg"/>
 
</head>