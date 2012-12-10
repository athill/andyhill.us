<?php
include("inc/application.php");
$appetizers = array(
	'id'=>"apps",
	'title' => "Appetizers",
	'items' => array(
		array( 'name'=>'Nacho Chips', 'descr'=>'Corn tortilla chips served with ' . 
			'nacho cheese', 'price'=>"3.75" ),
		array( 'name'=>'Nacho Chips Deluxe', 'descr'=>"Corn tortilla chips covered " . 
			"with taco meat, nacho cheese, sour cream, and tomatoes", 
			'price'=>"Large:6.50;Small:5.50" ),
		array( 'name'=>'Chicken Wings', 'descr'=>"BBQ or Hot chicken wings baked and " . 
			"served with ranch dressing and celery", 
			'price'=>"6 for:5.25;12 for:10.00" ),
		array( 'name'=>'Breadsticks', 'descr'=>'Five garlic buttered breadsticks ' . 
			'served with nacho cheese', 'price'=>"4.75" ),
		array( 'name'=>'Cheese Bread', 'descr'=>"Three slices of our Texas Toast " . 
			"style garlic bread baked with pizza cheese and served with " . 
			"Italian sauce", 'price'=>"5.00" ),
		array( 'name'=>'Pizza Bread', 'descr'=>"Three slices of our Texas Toast " . 
			"style garlic bread baked with pizza cheese and your choice " . 
			"of one pizza topping", 'price'=>"5.75" ),
		array( 'name'=>'Potato Chips', 'descr'=>"Additional cups of nacho cheese " . 
			"<strong>or</strong> Italian sauce ............ " . 
			"1.00", 'price'=>"1.50" )
	),
	'ps'=>'<div style="text-align: center;">Additional cups of nacho ' .
			'cheese<br />or Italian sauce ............ 1.00</div>'
);

$pizzas = array(
	'id'=>"pizzas",
	'title' => "Pizzas",
	'type'=>"grid",
	'items'=>array(
		array( 'name'=>"Royal Feast", 'toppings'=>"Pepperoni, Mushrooms, Onion, " .
			"Green Peppers, Sausage", 'prices'=>array(7.2,10.2,18.3,22.35)),
		array( 'name'=>"Grilled Chicken Ranch", 'toppings'=>"Garlic sauce, Ranch, " .
			"Onion, Bacon, Chicken, Tormatoes, Cheddar Cheese, and Provolone", 
	 		'prices'=>array(7.95,11.35,19.8,24.35)),
		array( 'name'=>"Meat Feast", 'toppings'=>"Pepperoni. Sausage, Baked Ham, " .
			"Bacon, Hamburger", 'prices'=>array(8.95,12.55,21.95,25.65)),
		array( 'name'=>"Veggie", 'toppings'=>"Mushrooms, Onion, " .
			"Green Peppers, Tomatoes, Black Olives", 'prices'=>array(7.2,10.2,18.3,22.35)),
		array( 'name'=>"Cowboy", 'toppings'=>"Double Pepperoni, Double Mushrooms, " .
			"Double Sausage, Double Cheese",'prices'=>array(8.95,12.55,21.95,25.65)),
		array( 'name'=>"Taco", 'toppings'=>"Refried Beans, Taco Meat, Lettuce, " .
			"Tomatoes", 'prices'=>array(7.2,10.2,18.3,22.35)),
		array( 'name'=>"BLT", 'toppings'=>"Bacon, Mayonaise, Lettuce, Tormato", 		'prices'=>array(7.2,10.2,18.3,22.35)),
		array( 'name'=>"Cheese", 'prices'=>array(4.95,6.75,12.8,15.95)),
		array( 'name'=>"One Item", 'prices'=>array(5.7,7.8,14.6,18.1)),
		array( 'name'=>"Two Items", 'prices'=>array(6.45,8.98,16.4,20.25)),
		array( 'name'=>"Additional Item", 'prices'=>array(0.75,1.15,1.8,2.15)),
		array( 'name'=>"Extra Cheese",  'prices'=>array(1.25,1.55,2.5,2.8)),
		array( 'name'=>"Barbecue",  'prices'=>array(0.4,0.6,1.0,1.5)),
		array( 'name'=>"Sour Cream (on pizza)", 'prices'=>array(0.6,0.95,1.9,2.3))
	),
	'ps'=>'<strong>Pan Pizza Available in 10" and 14" add $1.00 or $2.00' . 
		'</strong><br /><br /><div style="text-align: center;">' .
		'Pepperoni, Sausage, Baked Ham, Bacon, Hamburger, Chicken, ' . 
		'Anchovies, Mushrooms, Black O1ives , Onions, Green Peppers, ' .
		'Tomatoes, Banana Peppers, Jalapeno Peppers, and Pineapple' .	
		'</div>'
);

$mexican = array(
	'id'=>"mex",
	'title' => "Mexican Food",
	'items' => array(
		array( 'name'=>'Tacos (Hard or Soft Shell)', 
			'descr'=>'Flour or com tortilla filled with beef, cheese, ' . 
				'lettuce, and sauce', 
			'price'=>"1.75<br />3 for $5.00 " ),
		array( 'name'=>'Burritos (Beef and Bean Only)', 
			'descr'=>' Soft flour tortilla made to your specifications ' . 
				'with shredded cheddar cheese, lettuce, and sauce', 
			'price'=>"4.50" ),
		array( 'name'=>'Mexican Plate', 
			'descr'=>'Beef burrito, hard shell taco, lettuce, tomatoes, sour ' . 
				'cream, and beans all on the side', 
			'price'=>"6.50" ),
		array( 'name'=>'Taco Salad', 
			'descr'=>'Bed of ,lettuce surrounded with crispy tortilla chips ' . 
				'and topped with beef, cheese, tomatoes, and sauce', 
			'price'=>"Small 5.75<br />Large 6.50" )						
	),
	'ps'=>'Tomatoes or Sour Cream:<br />Add $1.00 for every burrito or 3 tacos'

);

$pasta = array(
	'id'=>"pasta",
	'title' => "Pasta",
	'items' => array(
		array( 'name'=>'Large Baked Spaghetti', 
			'descr'=>'A large order of spaghetti with meat sauce topped ' . 
				'with pizza cheese then baked to perfection. Indudes a ' . 
				'garden salad with two slices of garlic bread', 
			'price'=>"8.00" ),
		array( 'name'=>'Small Baked Spaghetti', 
			'descr'=>'A half of order of spaghetti with meat sauce topped ' .
				'with pizza cheese then baked to perfection. Also includes ' . 
				'one slice of garlic bread', 
			'price'=>"5.25" ),
		array( 'name'=>'Large Spaghetti', 
			'descr'=>'A large order of spaghetti with meat sauce. Also ' . 
				'includes a garden salad and two slices of garlic bread', 
			'price'=>"7.00" ),
		array( 'name'=>'Small Spaghetti', 
			'descr'=>'  A half of order of spaghetti with meat sauce served ' . 
				'with one slice of garlic bread', 
			'price'=>"4.75" )			
	)
);

$salads = array(
	'id'=>"salads",
	'title' => "Salads",
	'items' => array(
		array( 'name'=>'Garden Salad', 
			'descr'=>"Tossed salad that's perfect with pizza or with a sandwich", 
			'price'=>"2.50" ),
		array( 'name'=>'Junior Chef Salad', 
			'descr'=>'A smaller version of the large chef salad without egg', 
			'price'=>"5.50" ),
		array( 'name'=>'Large Chef Salad', 
			'descr'=>'Our tossed salad greens topped with pizza cheese, ' . 
				'egg, and your choice of ham or chicken', 
			'price'=>"6.50" ),			
	),
	'ps'=>'<div style="text-align: center;"><strong>Dressing:</strong> Ranch, Fat Free Ranch, ' .
		'French, Fat Free French, 1000 Island, Roquefort, Italian, and Poppy ' .
		'Seed<br /><br />' .
   		'<strong>Extra Dressing 1.00&nbsp;&nbsp;&nbsp;Add Egg 1.00</strong></div>'

);


$menus = array(
	$pizzas,
	$appetizers,
	$mexican,
	$pasta,
	$salads
);

$h->odiv();
$h->odiv('style="margin: 0 auto; width: 40em;"');
////Menu menu

$items = array();
for ($i = 0; $i < count($menus); $i++) {
	$menu = $menus[$i];
	$h->startBuffer();
	$h->a('#'.$menu['id'], $menu['title']);
	$items[] = $h->endBuffer();
}
$h->listArray("ul", $items);

////Display menus
for ($i = 0; $i < count($menus); $i++) {
	$menu = $menus[$i];
	////Start menu div
	$h->odiv('class="menu-section" id="'. $menu['id'] .'"');
	$h->div($menu['title'], 'class="menu-section-title"');		
	$h->tag("a", 'name="' . $menu['id'] . '"', '');
	////delegate menu display
	
	switch ($menu['type']) {
		case "grid":
			displayGridMenu($menu['items']);		
			break;
		case "menu":
		default:
			displayMenu($menu['items']);		
			break;
	}
	if (array_key_exists('ps', $menu)) {
		$h->tnl($menu['ps']);
	} 
	$h->br(2);
	$h->a('#top', "Return to Top", 'class="backtotop"');
	////Close menu div
	$h->cdiv();	//close menu-section	
}
$h->cdiv();
$h->cdiv();



function displayGridMenu($items) {
	global $h;
	$headers = array('', '8"', '10"', '14"', '16"');
	$h->otable('class="menu-table"');
	for ($i = 0; $i < count($headers); $i++) {
		$h->th($headers[$i]);
	}
	for ($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$h->cotr();
		$h->otd();
		$h->div($item['name'], 'class="menu-item-name"');
		if (array_key_exists("toppings", $item)) {
			$h->div($item['toppings'], 'class="menu-item-descr"');
		}
		$h->ctd();
		for ($j = 0; $j < count($item['prices']); $j++) {
			$h->td($item['prices'][$j]);
		}
	}
	$h->ctable();
}

                             



function displayMenu($items) {
	global $h;
	for ($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$h->odiv('class="menu-item"');
		$h->odiv('class="menu-item-name-price-row"');
		$h->div($item['name'], 'class="menu-item-name left"');
		$price = preg_replace("/;/", "<br />", $item['price']);
		$price = preg_replace("/:/", "&nbsp;", $price);
		$h->div($price, 'class="menu-item-price right"');
		$h->cdiv();
		$h->div($item['descr'], 'class="menu-item-descr"');
		$h->cdiv();
	}
}                                                
          

                           

              
          
                            
         






if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>
