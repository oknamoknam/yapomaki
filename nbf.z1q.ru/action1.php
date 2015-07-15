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
				<div class="elgrandelink"><a href="http://www.elgrande.su"><img src="/images/gif.gif" width="80px" height="50px"></a></div>
				
				<div class="MenuL"></div>
				<div class="MenuR"></div>
			</div>			
			<div id="Page">
				<div id="Content">
				
				<div class="Conent">
					<div class="Title">
						<h1>АКЦИИ</h1>
					</div>
					<div class="Text-ak">
						<img src="/images/ak4.jpg">					
						
						
						<div class="text-ak-txt"></div>
					</div>
				</div>
				
				</div>
				<div id="Cart" style="display:none">	
					
				</div>
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