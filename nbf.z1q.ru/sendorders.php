<?php

/*
 * $OrderXML - xml которую надо передать с заказом
 * $OrderText - текст заказа
 * $wServ - наш веб сервис
 * $sendMetod - метод который мы вызываем(тут жестко название берем из Web сервиса)
 * 
 */

//$myXML = '
//<Order PayMethod = "Наличные" QtyPerson="3" Type="Доставка">
//	<Phone Code="916" Number="9987656" />
//		<Products>
//			<Product Code="1_110" Qty="15" >
//				<Remark><![CDATA[Комент к блюду]]></Remark>
//			</Product>
//		</Products>
//		<Remark><![CDATA[комент к заказу]]></Remark>
//</Order>
//';

include_once('inc/jcart.php');
session_start();


function rdr($par) { //F-ciya redirect s parametrom
	header("Location:" . $par);
	exit;
}

//подключаем защиту от ботов
require 'botobor.php';

if (Botobor_Keeper::isHuman())
{
  // Форма отправлена человеком, можно обрабатывать её.

    
    	//наши основные переменные
    	$wServ = 'http://79.104.31.46:1982/FastOperator.asmx';
    	$sendMetod = 'AddOrder';
    	$BadSimbol = array("8 (", ")", "-",);
    
    	//разбираем телефон на код города и номер
    	$CustomerPhone = str_replace($BadSimbol, "", $_POST['CustomerPhone']);
    	list($PhoneCode, $PhoneBody) = explode(" ", $CustomerPhone);
    
    	//создаем OrderXML
    	$OrderXML = '<Order PayMethod = "Наличные" QtyPerson="' . $_POST['QtyPerson'] . '" Type="Доставка">';
    	$OrderXML .= '	<Phone Code="' . $PhoneCode . '" Number="' . $PhoneBody . '" />';
    	$cart_contents = $jcart->get_contents();
    	$OrderXML .= '<Products>';
    	foreach($cart_contents as $k => $v) {
    		$OrderXML .= '<Product Code="' . $v[id] . '" Qty="' . $v[qty] . '" >';
    		$OrderXML .= '	<Remark><![CDATA[]]></Remark>';
    		$OrderXML .= '</Product>';
    	}
    	$OrderXML .= '</Products>';
    	$OrderXML .= '<Remark><![CDATA[]]></Remark>';
    	$OrderXML .= '</Order>';
    
    	//создаем текст заказа 
    	$OrderText = "Текст заказа \r\n";
    	$OrderText .= "----------------------- \r\n";
    	$OrderText .= "Телефон заказчика: " . $_POST['CustomerPhone'] . " \r\n";
    	$OrderText .= "Заказанная продукция \r\n";
    	foreach($cart_contents as $k => $v) {
//    		$OrderText .= $v[name]."*".$v[qty]." kod=" . $v[id] . "\r\n";
    		$OrderText .= $v[name]." x".$v[qty]."\r\n";
    	}
    	if(!empty($_SESSION['ref'])) {
    		$OrderText .= "----------------------- \r\n";
    		$OrderText .= "REF =". $_SESSION['ref'];
    	}
    	
    	function GetAnswer($address, $myXML){ 
    		 $ch = curl_init($address); 
    		 curl_setopt($ch, CURLOPT_HEADER, 0); 
    		 curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
    		 curl_setopt($ch, CURLOPT_POST,1); 
    		 //чтобы в текст заказа попала xml надо изменить на OrderText='.$myXML[0] или наоборот OrderText='.$myXML[1]
    		 curl_setopt($ch, CURLOPT_POSTFIELDS, 'Order='.$myXML[0].'&OrderText='.$myXML[1]); 
    		 $result=curl_exec($ch); 
    		 return $result; 
    	   } 
    
    	//собираем всю инфу   
    	$myXML = array($OrderXML, $OrderText);
    
    	//отправляем запрос
    	$answer = GetAnswer($wServ."/".$sendMetod, $myXML); 
    	session_unset();
    	session_destroy();
    
    	//смотрим ответ
    	//echo $answer;
    	//извлечение номера заказа
    	$izvlanswer = substr($answer, 95, 6);
    
    	rdr("/checkout.php?numb=".$izvlanswer); 
    	//смотрим ответ
    	echo $answer;


}
else {
    rdr("/checkout.php"); 
}

?>
