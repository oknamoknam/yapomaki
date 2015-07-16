<?php
	include_once('inc/jcart.php');
//	print session_id();
//	if(!empty($_GET['PHPSESSID'])) {
//		print 1;
//		session_id($_GET['PHPSESSID']);
//	}
	session_start();
//	print $_SESSION['ref'];
//print session_id();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include('core/head.inc') ?>
<body>
<div id="uwc">
<div id="Underwater">

	<div id="Sea">
		<div id="Light"></div>
        
		<!-- Page centr -->
		<div id="Container">
			<div id="Header">
				<?php include('core/header.inc') ?>
			</div>
			<div id="Menu">
				<ul>
					<?php include('core/menu.inc') ?>
				</ul>
			
				<div class="MenuL"></div>
				<div class="MenuR"></div>
			</div>			
			<div id="Page">
				<div id="Content">
					<!-- ?php include('catalog/items/cat-2.inc') ?> -->
					<?php 
					$cat = $_GET['cat'];
						if($cat =='1') { include ('catalog/items/cat-1.inc'); } 
					elseif($cat =='2') { include ('catalog/items/cat-2.inc'); } 
					elseif($cat =='3') { include ('catalog/items/cat-3.inc'); }
					elseif($cat =='4') { include ('catalog/items/cat-4.inc'); }
					elseif($cat =='5') { include ('catalog/items/cat-5.inc'); }
					elseif($cat =='6') { include ('catalog/items/cat-6.inc'); }
					elseif($cat =='7') { include ('catalog/items/cat-7.inc'); }
					elseif($cat =='8') { include ('catalog/items/cat-8.inc'); }
					elseif($cat =='9') { include ('catalog/items/cat-9.inc'); }
					elseif($cat =='10') { include ('catalog/items/cat-10.inc'); }
					elseif($cat =='11') { include ('catalog/items/cat-11.inc'); }
					elseif($cat =='12') { include ('catalog/items/cat-12.inc'); }
					elseif($cat =='14') { include ('catalog/items/cat-14.inc'); }
					elseif($cat =='16') { include ('catalog/items/cat-16.inc'); }
					else { include ('catalog/items/cat-2.inc'); }
					?>
				</div>
					<?php 
	// if (date("H:i") > "10:30" && date("H:i") < "23:59" ) {
		if(	$cat > 0) { 
			print('<div id="Cart">	');
			$jcart->display_cart(); 
			print('</div>');
		} else {
			print('<div id="Cart">	');
			$jcart->display_cart();
			//print('<!-- CART Disabled -->');
		}
	// } else {
	// 	print('<div id="Cart"><div class="edndaytext">	');
	// 		print "Рабочий день закончился. Заказы временно не принимаются.";
	// 	print('</div></div>');
					
	// }
					?>
				<div class="Clear"></div>	
			<?php
				if($cat == 10) {
					$fhi = 337;
					$ffhi = 214;
				} else {
					$fhi = 385;
					$ffhi = 234;
				}
			echo "<div id=\"Footer\" style=\"height: ".$fhi."px;\">";
			// echo "<div id=\"Footer\" style=\"height: 385px;\">";
			if (empty($cat)) {
				$cat = 2;
			}
				include_once('text.php');
				echo "<div style=\"width: 928px; height: ".$ffhi."px;\">";
				// echo "<div style=\"width: 928px; height: 234px;\">";
					if($cat == 10) {
						echo "<div class=\"text_bottom  text_bottom_big\">";
							echo "<h1>".$tit_1."</h1>";
							echo "<span>".$text_1."</span>";
						echo "</div>";
						echo "<div class=\"text_bottom text_bottom_big\">";
							echo "<h1>".$tit_2."</h1>";
							echo "<span>".$text_2."</span>";
						echo "</div>";
						echo "<div class=\"Clear\"></div>";
					} else {
						echo "<div class=\"text_bottom\">";
							echo "<h1>".$tit_1."</h1>";
							echo "<span>".$text_1."</span>";
						echo "</div>";
						echo "<div class=\"text_bottom\">";
							echo "<h1>".$tit_2."</h1>";
							echo "<span>".$text_2."</span>";
						echo "</div>";
						echo "<div class=\"text_bottom\">";
							echo "<h1>".$tit_3."</h1>";
							echo "<span>".$text_3."</span>";
						echo "</div>";
						echo "<div class=\"Clear\"></div>";
					}
				echo "</div>";
			?>
				<?php include('core/footer.inc') ?>
				
			</div>
			</div>
			<div class="BoobleL"></div>
			<div class="BoobleR"></div>
		</div>
		<!-- /Page centred -->
	</div>
</div>
</div>
<!-- Время на сервере: <? echo date("c"); ?> -->
<script type="text/javascript">
    var __gra = __gra || [];
    __gra.mid = 10703;
    (function() {
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.async = true;
        s.src = "http:" + "//js.grt" + "01.com/" + "gra_min_new.js";
        var x = document.getElementsByTagName("script")[0];
        x.parentNode.insertBefore(s, x);
    })();
</script>
</body>
</html>