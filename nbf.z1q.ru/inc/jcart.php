<?php

// jCart v1.3
// http://conceptlogic.com/jcart/

//error_reporting(E_ALL);

// Cart logic based on Webforce Cart: http://www.webforcecart.com/
class Jcart {

	public $config     = array();
	private $items     = array();
	private $names     = array();
	private $prices    = array();
	private $qtys      = array();
	private $urls      = array();
	private $subtotal  = 0;
	private $itemCount = 0;

	function __construct() {

		// Get $config array
		include_once('config-loader.php');
		$this->config = $config;
	}

	/**
	* Get cart contents
	*
	* @return array
	*/
	public function get_contents() {
		$items = array();
		foreach($this->items as $tmpItem) {
			$item = null;
			$item['id']       = $tmpItem;
			$item['name']     = $this->names[$tmpItem];
			$item['price']    = $this->prices[$tmpItem];
			$item['qty']      = $this->qtys[$tmpItem];
			$item['url']      = $this->urls[$tmpItem];
			$item['subtotal'] = $item['price'] * $item['qty'];
			$items[]          = $item;
		}
		return $items;
	}

	/**
	* Add an item to the cart
	*
	* @param string $id
	* @param string $name
	* @param float $price
	* @param mixed $qty
	* @param string $url
	*
	* @return mixed
	*/
	private function add_item($id, $name, $price, $qty = 1, $url) {

		$validPrice = false;
		$validQty = false;

		// Verify the price is numeric
		if (is_numeric($price)) {
			$validPrice = true;
		}

		// If decimal quantities are enabled, verify the quantity is a positive float
		if ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT) && $qty > 0) {
			$validQty = true;
		}
		// By default, verify the quantity is a positive integer
		elseif (filter_var($qty, FILTER_VALIDATE_INT) && $qty > 0) {
			$validQty = true;
		}

		// Add the item
		if ($validPrice !== false && $validQty !== false) {

			// If the item is already in the cart, increase its quantity
			if($this->qtys[$id] > 0) {
				$this->qtys[$id] += $qty;
				$this->update_subtotal();
			}
			// This is a new item
			else {
				$this->items[]     = $id;
				$this->names[$id]  = $name;
				$this->prices[$id] = $price;
				$this->qtys[$id]   = $qty;
				$this->urls[$id]   = $url;
			}
			$this->update_subtotal();
			return true;
		}
		elseif ($validPrice !== true) {
			$errorType = 'price';
			return $errorType;
		}
		elseif ($validQty !== true) {
			$errorType = 'qty';
			return $errorType;
		}
	}

	/**
	* Update an item in the cart
	*
	* @param string $id
	* @param mixed $qty
	*
	* @return boolean
	*/
	private function update_item($id, $qty) {

		// If the quantity is zero, no futher validation is required
		if ((int) $qty === 0) {
			$validQty = true;
		}
		// If decimal quantities are enabled, verify it's a float
		elseif ($this->config['decimalQtys'] === true && filter_var($qty, FILTER_VALIDATE_FLOAT)) {
			$validQty = true;
		}
		// By default, verify the quantity is an integer
		elseif (filter_var($qty, FILTER_VALIDATE_INT))	{
			$validQty = true;
		}

		// If it's a valid quantity, remove or update as necessary
		if ($validQty === true) {
			if($qty < 1) {
				$this->remove_item($id);
			}
			else {
				$this->qtys[$id] = $qty;
			}
			$this->update_subtotal();
			return true;
		}
	}


	/* Using post vars to remove items doesn't work because we have to pass the
	id of the item to be removed as the value of the button. If using an input
	with type submit, all browsers display the item id, instead of allowing for
	user-friendly text. If using an input with type image, IE does not submit
	the	value, only x and y coordinates where button was clicked. Can't use a
	hidden input either since the cart form has to encompass all items to
	recalculate	subtotal when a quantity is changed, which means there are
	multiple remove	buttons and no way to associate them with the correct
	hidden input. */

	/**
	* Reamove an item from the cart
	*
	* @param string $id	*
	*/
	private function remove_item($id) {
		$tmpItems = array();

		unset($this->names[$id]);
		unset($this->prices[$id]);
		unset($this->qtys[$id]);
		unset($this->urls[$id]);

		// Rebuild the items array, excluding the id we just removed
		foreach($this->items as $item) {
			if($item != $id) {
				$tmpItems[] = $item;
			}
		}
		$this->items = $tmpItems;
		$this->update_subtotal();
	}
	/**
	* Empty the cart
	*/
	public function empty_cart() {
		$this->items     = array();
		$this->names     = array();
		$this->prices    = array();
		$this->qtys      = array();
		$this->urls      = array();
		$this->subtotal  = 0;
		$this->itemCount = 0;
	}

	/**
	* Update the entire cart
	*/
	public function update_cart() {

		// Post value is an array of all item quantities in the cart
		// Treat array as a string for validation
		if (is_array($_POST['jcartItemQty'])) {
			$qtys = implode($_POST['jcartItemQty']);
		}

		// If no item ids, the cart is empty
		if ($_POST['jcartItemId']) {

			$validQtys = false;

			// If decimal quantities are enabled, verify the combined string only contain digits and decimal points
			if ($this->config['decimalQtys'] === true && preg_match("/^[0-9.]+$/i", $qtys)) {
				$validQtys = true;
			}
			// By default, verify the string only contains integers
			elseif (filter_var($qtys, FILTER_VALIDATE_INT) || $qtys == '') {
				$validQtys = true;
			}

			if ($validQtys === true) {

				// The item index
				$count = 0;

				// For each item in the cart, remove or update as necessary
				foreach ($_POST['jcartItemId'] as $id) {

					$qty = $_POST['jcartItemQty'][$count];

					if($qty < 1) {
						$this->remove_item($id);
					}
					else {
						$this->update_item($id, $qty);
					}

					// Increment index for the next item
					$count++;
				}
				return true;
			}
		}
		// If no items in the cart, return true to prevent unnecssary error message
		elseif (!$_POST['jcartItemId']) {
			return true;
		}
	}

	/**
	* Recalculate subtotal
	*/
	private function update_subtotal() {
		$this->itemCount = 0;
		$this->subtotal  = 0;

		if(sizeof($this->items > 0)) {
			foreach($this->items as $item) {
				$this->subtotal += ($this->qtys[$item] * $this->prices[$item]);

				// Total number of items
				$this->itemCount += $this->qtys[$item];
			}
		}
	}

	/**
	* Process and display cart
	*/
	public function display_cart() {

		$config = $this->config; 
		$errorMessage = null;

		// Simplify some config variables
		$checkout = $config['checkoutPath'];
		$priceFormat = $config['priceFormat'];

		$id    = $config['item']['id'];
		$name  = $config['item']['name'];
		$price = $config['item']['price'];
		$qty   = $config['item']['qty'];
		$url   = $config['item']['url'];
		$add   = $config['item']['add'];

		// Use config values as literal indices for incoming POST values
		// Values are the HTML name attributes set in config.json
		$id    = $_POST[$id];
		$name  = $_POST[$name];
		$price = $_POST[$price];
		$qty   = $_POST[$qty];
		$url   = $_POST[$url];

		// Optional CSRF protection, see: http://conceptlogic.com/jcart/security.php
		$jcartToken = $_POST['jcartToken'];

		// Only generate unique token once per session
		if(!$_SESSION['jcartToken']){
			$_SESSION['jcartToken'] = md5(session_id() . time() . $_SERVER['HTTP_USER_AGENT']);
		}
		// If enabled, check submitted token against session token for POST requests
		if ($config['csrfToken'] === 'true' && $_POST && $jcartToken != $_SESSION['jcartToken']) {
			$errorMessage = 'Invalid token!' . $jcartToken . ' / ' . $_SESSION['jcartToken'];
		}

		// Sanitize values for output in the browser
		$id    = filter_var($id, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$name  = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
		$url   = filter_var($url, FILTER_SANITIZE_URL);

		// Round the quantity if necessary
		if($config['decimalPlaces'] === true) {
			$qty = round($qty, $config['decimalPlaces']);
		}

		// Add an item
		if ($_POST[$add]) {
			$itemAdded = $this->add_item($id, $name, $price, $qty, $url);
			// If not true the add item function returns the error type
			if ($itemAdded !== true) {
				$errorType = $itemAdded;
				switch($errorType) {
					case 'qty':
						$errorMessage = $config['text']['quantityError'];
						break;
					case 'price':
						$errorMessage = $config['text']['priceError'];
						break;
				}
			}
		}

		// Update a single item
		if ($_POST['jcartUpdate']) {
			$itemUpdated = $this->update_item($_POST['itemId'], $_POST['itemQty']);
			if ($itemUpdated !== true)	{
				$errorMessage = $config['text']['quantityError'];
			}
		}

		// Update all items in the cart
		if($_POST['jcartUpdateCart'] || $_POST['jcartCheckout'])	{
			$cartUpdated = $this->update_cart();
			if ($cartUpdated !== true)	{
				$errorMessage = $config['text']['quantityError'];
			}
		}
		
		
		// Remove an item
		/* After an item is removed, its id stays set in the query string,
		preventing the same item from being added back to the cart in
		subsequent POST requests.  As result, it's not enough to check for
		GET before deleting the item, must also check that this isn't a POST
		request. */
		if($_GET['jcartRemove'] && !$_POST) {
			$this->remove_item($_GET['jcartRemove']);
		}

		// Empty the cart
		if($_POST['jcartEmpty']) {
			$this->empty_cart();
		}
		
		
		
		// Determine which text to use for the number of items in the cart
		$itemsText = $config['text']['multipleItems'];
		if ($this->itemCount == 1) {
			$itemsText = $config['text']['singleItem'];
		}

		// Determine if this is the checkout page
		/* First we check the request uri against the config checkout (set when
		the visitor first clicks checkout), then check for the hidden input
		sent with Ajax request (set when visitor has javascript enabled and
		updates an item quantity). */
		$isCheckout = strpos(request_uri(), $checkout);
		if ($isCheckout !== false || $_REQUEST['jcartIsCheckout'] == 'true') {
			$isCheckout = true;
		}
		else {
			$isCheckout = false;
		}

		// Overwrite the form action to post to gateway.php instead of posting back to checkout page
		if ($isCheckout === true) {

			// Sanititze config path
			$path = filter_var($config['jcartPath'], FILTER_SANITIZE_URL);

			// Trim trailing slash if necessary
			$path = rtrim($path, '/');

			$checkout = $path . '/gateway.php';
		}

		// Default input type
		// Overridden if using button images in config.php
		$inputType = 'submit';

		// If this error is true the visitor updated the cart from the checkout page using an invalid price format
		// Passed as a session var since the checkout page uses a header redirect
		// If passed via GET the query string stays set even after subsequent POST requests
		if ($_SESSION['quantityError'] === true) {
			$errorMessage = $config['text']['quantityError'];
			unset($_SESSION['quantityError']);
		}

		// Set currency symbol based on config currency code
		$currencyCode = trim(strtoupper($config['currencyCode']));
		switch($currencyCode) {
			case 'RUB':
				$currencySymbol = 'руб.';
				break;
			case 'USD':
			default:
				$currencySymbol = '$';
				break;
		}

		////////////////////////////////////////////////////////////////////////
		// Output the cart

		// Return specified number of tabs to improve readability of HTML output
		function tab($n) {
			$tabs = null;
			while ($n > 0) {
				$tabs .= "\t";
				--$n;
			}
			return $tabs;
		}

		// If there's an error message wrap it in some HTML
		if ($errorMessage)	{
			$errorMessage = "<p id='jcart-error'>$errorMessage</p>";
		}
		// if (date("H:i") > "10:30" && date("H:i") < "23:59" ) {
		// Display the cart header
		echo tab(1) . "<div id='Checkout'>\n";
		echo tab(4) . "<div class='Top'></div>\n";
		echo tab(4) . "<form method='post' action='$checkout'>\n";
		echo tab(4) . "<input type='hidden' name='Token' value='{$_SESSION['jcartToken']}' />\n";
		echo tab(4) . "<!-- {$config['text']['cartTitle']} ($this->itemCount $itemsText) -->\n";
		echo tab(4) . "<div id='ItemList'>\n<div id='Scrollable'>";
		
		// If any items in the cart
		if($this->itemCount > 0) {
			// Display line items
			$items = array_reverse($this->get_contents()); //added reverse sort - lich
			//natsort($items);
			foreach ($items as $item) {
				echo tab(5) . "<dl id='Cart_{$item['id']}'>\n";
				echo tab(6) . "<input name='jcartItemId[]' type='hidden' value='{$item['id']}' />\n";
				echo tab(6) . "<i>{$item['qty']}</i><img src='{$item['url']}{$item['id']}_s.jpg'><p>{$item['name']}</p><b>{$item['price']} р.</b><ul><li><a class='jcart-minus' href='?jcartMinus={$item['id']}={$item['qty']}'></a></li><li><a class='jcart-plus' href='?jcartPlus={$item['id']}={$item['qty']}'></a></li><li><a class='jcart-remove' href='?jcartRemove={$item['id']}'></a></li></ul>\n";
				echo tab(5) . "</dl>\n";
			}
		} else {
			echo tab(5) . "<dl class='empty'><dd>Ваша корзина пуста. </br>Кликните на интересующее Вас блюдо для добавления</br> его в корзину.</dd></dl>\n";
		}

		echo tab(4) . "</div>\n</div>";
		// Display the cart footer		
		echo tab(4) . "<div class='Bottom'></div>\n";
		echo tab(4) . "<div class='Total'>\n";
		echo tab(5) . "<div class='Summ'>Сумма заказа: <span id='Summ'><b>" . number_format($this->subtotal /*, $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep'] */) . "</b> р.</span></div>\n";
		if ($this->itemCount > 0 && $this->subtotal > 499){ //lich - 2nd condition
			echo tab(5) . "<input type='submit' id='jcart-checkout' name='jcartCheckout' value=' '>\n";
		} else {
			echo tab(5) . "<input type='submit' id='jcart-checkout' name='jcartCheckout' value=' ' disabled='disabled'>\n";	
		}
		echo tab(5) . "<div class='Info'>Минимальная сумма<br>заказа 500 р.</div>\n";
		echo tab(4) . "</div>\n";	
		echo tab(4) . "</form>\n";
		echo tab(3) . "</div>\n";
		echo tab(2) . "</div>\n";
		// } else {
		// 	print "<div class=\"edndaytext\">Рабочий день закончился. Заказы временно не принимаются.</div>";
		// }
	}

   //lich
   public function display_summa() {
		$config = $this->config; 
		$priceFormat = $config['priceFormat'];
   	return number_format($this->subtotal/*, $priceFormat['decimals'], $priceFormat['dec_point'], $priceFormat['thousands_sep']*/);
   }
}



// Start a new session in case it hasn't already been started on the including page
@session_start();
if(!empty($_GET[ref])) $_SESSION['ref'] 	= $_GET[ref];
if(!empty($_SESSION['ref'])) $_SESSION['ref'] 	= $_SESSION['ref'];

// Initialize jcart after session start
$jcart = $_SESSION['jcart'];
if(!is_object($jcart)) {
	$jcart = $_SESSION['jcart'] = new Jcart();
}

// Enable request_uri for non-Apache environments
// See: http://api.drupal.org/api/function/request_uri/7
if (!function_exists('request_uri')) {
	function request_uri() {
		if (isset($_SERVER['REQUEST_URI'])) {
			$uri = $_SERVER['REQUEST_URI'];
		}
		else {
			if (isset($_SERVER['argv'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['argv'][0];
			}
			elseif (isset($_SERVER['QUERY_STRING'])) {
				$uri = $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING'];
			}
			else {
				$uri = $_SERVER['SCRIPT_NAME'];
			}
		}
		$uri = '/' . ltrim($uri, '/');
		return $uri;
	}
}
?>