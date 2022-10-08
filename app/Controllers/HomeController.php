<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Product;

class HomeController extends Controller
{
	public function __construct()
	{
		// if (!Guard::isUserLoggedIn()) {
		// 	redirect('/login');
		// }

		parent::__construct();
	}

	public function index()
	{

		$products = Product::getNewProduct(5);
		$this->sendPage('home', [
			'products' => $products
		]); 
	}

}
