<?php
	include_once('inc/jcart.php');
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<?php include('core/head.inc') ?>
<body>
<div id="uwc">
<div id="Underwater">
	<div id="Sea">
		<div id="Light"></div>
		<!-- Page centred -->
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
<? if (empty($_GET[numb])) { ?>
				<div class="Products Checkout">
					<div class="Carts"></div>
					<div class="Title">
						<h1>Ваша корзина</h1>
					</div>

					<div class="Text" id="chtxt">
					<? 
						//параметры заказа в корзине
						$cart_contents = $jcart->get_contents();

//foreach($cart_contents as $k => $v) {
//	echo "код -".$v[id]."<br />";
//	echo "Кол-во -".$v[qty]."<br />";
//}
//print_r($cart_contents);
//exit;
					?>
						<form name="checkout" action="/SendOrders.php" method='POST' id="jform">
							<div class="Right">
							В вашей корзине <b><?php echo count($cart_contents) ?></b> наименование(я).<br>
							Выбрано товаров на сумму: <b><?php echo $jcart->display_summa()?></b> руб.
							
							</div>
							<input id="jcart-checkout-ok" type="submit" name="" value="">
							
							<div class="numbtel">Номер телефона: <input class="SendPhoneE" type="text" name="CustomerPhone" id="CustomerPhone" value=""></div>
<div class="kolvoperson">Кол-во персон: <input class="SendQtyPersonG" type="text" id="QtyPerson" value="1"></div> 
							</form>					
					</div>
                   
				</div>
<!-- TEMP -->
<div class="Checkout">
<div class="Title" name="1">
	<h1>СОСТАВ ЗАКАЗА</h1>
</div>
<ul class="Items">
<!-- START -->
	<li>
	<form method="post" action="" class="jcart" id="Item_4_110">
		<input type="hidden" name="Token" value="<?php echo $_SESSION['jcartToken'];?>" />
		<input type="hidden" name="my-item-id" value="4_110" />
		<input type="hidden" name="my-item-name" value="Чука" />
		<input type="hidden" name="my-item-price" value="70" />
		<input type="hidden" name="my-item-url" value="/catalog/rolls/" />
		<input class="qty" type="text" name="my-item-qty" value="qty"/>
		<div><img src="/catalog/rolls/4_110.jpg"></div>
		<h3>Чука</h3>
		<p>Чука, рис, нори</br><b class="veskal">110 г., 205 ккал</b></p>
		<span><b>70 р.</b> | <a class='jcart-minus' href='?jcartMinus=id=qty'>-</a> | <a class='jcart-plus' href='?jcartPlus=id=qty'>+</a> | <a class='jcart-remove' href='?jcartRemove=id'>x</a></span>		
	</form>
	</li>
	
	<li>
	<form method="post" action="" class="jcart" id="Item_4_110">
		<input type="hidden" name="Token" value="<?php echo $_SESSION['jcartToken'];?>" />
		<input type="hidden" name="my-item-id" value="4_110" />
		<input type="hidden" name="my-item-name" value="Чука" />
		<input type="hidden" name="my-item-price" value="70" />
		<input type="hidden" name="my-item-url" value="/catalog/rolls/" />
		<input class="qty" type="text" name="my-item-qty" value="qty"/>
		<div><img src="/catalog/rolls/4_110.jpg"></div>
		<h3>Чука</h3>
		<p>Чука, рис, нори</br><b class="veskal">110 г., 205 ккал</b></p>
		<span><b>70 р.</b> | <a class='jcart-minus' href='?jcartMinus=id=qty'>-</a> | <a class='jcart-plus' href='?jcartPlus=id=qty'>+</a> | <a class='jcart-remove' href='?jcartRemove=id'>x</a></span>		
	</form>
	</li>
	
	<li>
	<form method="post" action="" class="jcart" id="Item_4_110">
		<input type="hidden" name="Token" value="<?php echo $_SESSION['jcartToken'];?>" />
		<input type="hidden" name="my-item-id" value="4_110" />
		<input type="hidden" name="my-item-name" value="Чука" />
		<input type="hidden" name="my-item-price" value="70" />
		<input type="hidden" name="my-item-url" value="/catalog/rolls/" />
		<input class="qty" type="text" name="my-item-qty" value="qty"/>
		<div><img src="/catalog/rolls/4_110.jpg"></div>
		<h3>Чука</h3>
		<p>Чука, рис, нори</br><b class="veskal">110 г., 205 ккал</b></p>
		<span><b>70 р.</b> | <a class='jcart-minus' href='?jcartMinus=id=qty'>-</a> | <a class='jcart-plus' href='?jcartPlus=id=qty'>+</a> | <a class='jcart-remove' href='?jcartRemove=id'>x</a></span>		
	</form>
	</li>
	
	<li>
	<form method="post" action="" class="jcart" id="Item_4_110">
		<input type="hidden" name="Token" value="<?php echo $_SESSION['jcartToken'];?>" />
		<input type="hidden" name="my-item-id" value="4_110" />
		<input type="hidden" name="my-item-name" value="Чука" />
		<input type="hidden" name="my-item-price" value="70" />
		<input type="hidden" name="my-item-url" value="/catalog/rolls/" />
		<input class="qty" type="text" name="my-item-qty" value="qty"/>
		<div><img src="/catalog/rolls/4_110.jpg"></div>
		<h3>Чука</h3>
		<p>Чука, рис, нори</br><b class="veskal">110 г., 205 ккал</b></p>
		<span><b>70 р.</b> | <a class='jcart-minus' href='?jcartMinus=id=qty'>-</a> | <a class='jcart-plus' href='?jcartPlus=id=qty'>+</a> | <a class='jcart-remove' href='?jcartRemove=id'>x</a></span>		
	</form>
	</li>
	
	<li>
	<form method="post" action="" class="jcart" id="Item_4_110">
		<input type="hidden" name="Token" value="<?php echo $_SESSION['jcartToken'];?>" />
		<input type="hidden" name="my-item-id" value="4_110" />
		<input type="hidden" name="my-item-name" value="Чука" />
		<input type="hidden" name="my-item-price" value="70" />
		<input type="hidden" name="my-item-url" value="/catalog/rolls/" />
		<input class="qty" type="text" name="my-item-qty" value="qty"/>
		<div><img src="/catalog/rolls/4_110.jpg"></div>
		<h3>Чука</h3>
		<p>Чука, рис, нори</br><b class="veskal">110 г., 205 ккал</b></p>
		<span><b>70 р.</b> | <a class='jcart-minus' href='?jcartMinus=id=qty'>-</a> | <a class='jcart-plus' href='?jcartPlus=id=qty'>+</a> | <a class='jcart-remove' href='?jcartRemove=id'>x</a></span>		
	</form>
	</li>
<!-- END --><br />
 <div class="txtchkout">Укажите телефон и кол-во персон.</div>
<br class="Clear" />	
</ul>
</div>
<!-- TEMP -->
					<?php
						//print('<pre>');
						//var_dump($_SESSION['jcart']);
						//var_dump($cart_contents);
						//print('</pre>');
						
					?>					
					<!-- CART -->
					<!-- ?php $jcart->display_cart();?>
					<!-- /CART -->					
				
				</div>
				<? } else { ?>
				
				<div class="Conent">
					<div class="Title">
						<h1>ЗАКАЗ ОТПРАВЛЕН</h1>
					</div>
					<div class="Text">
						<p>Вашему заказу присвоен номер:<b class="NumOrder"> <?php echo $_GET[numb]; ?></b>.</p>

						<p>В течении нескольких минут с Вами свяжется оператор.</br>Пожалуйста не выключайте телефон и дождитесь звонка от оператора!</p>
						<p>Спасибо что выбрали нас, приятного аппетита!</p>	

					</div>
				</div></div>
				
				
				<? } ?>
				<div class="Clear"></div>	
			<div id="Footer">
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
</body>