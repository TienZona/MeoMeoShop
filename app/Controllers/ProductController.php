<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;

use App\Models\Product;
use App\Models\ProductDetail;


class ProductController extends Controller
{
	private $numberItem = 4;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	
	{
		$numberProduct = 0;
		$page = $_GET['page'] ?? 0;

		// get category
		$id_category = $_GET['category'] ?? 0;
		// get products
		$products = null;
		$act = $_GET['act'] ?? null;

		$domain = $this->getDomain($_GET['fil'] ?? 0);
		switch($act){
			case 'giacao': 
				if(isset($_GET['category'])){
					$products = Product::getProductIncrementByCate($page, $this->numberItem, $domain, $_GET['category']);
				}else{
					$products = Product::getProductIncrement($page, $this->numberItem, $domain);
				}

				break;
			case 'giathap':
				if(isset($_GET['category'])){
					$products = Product::getProductDecrementByCate($page, $this->numberItem, $domain, $_GET['category']);
				}else{
					$products = Product::getProductDecrement($page, $this->numberItem, $domain);
				}
				break;
			case 'giamgia':
				$products = [];
				break;
			case 'banchay':
				$products = [];

				break;
			default:
				if(isset($_GET['category'])){
					$products = Product::getProductByCategory($page, $this->numberItem, $domain, $_GET['category']);
				}else{
					$products = Product::getAllProduct($page, $this->numberItem, $domain);
				}
		}

		if(isset($_GET['search'])){
			$name = $_GET['search'];
			$products = Product::searchProduct($name);
		}

		// handle number product on page

		$numberProduct = Product::getNumberProduct($id_category, $domain);

		$this->renderProduct($products, $page, $numberProduct);
	}

	public function search(){
		$numberProduct = 0;
		$page = $_GET['page'] ?? 0;
		$products = null;

		if(isset($_GET['search'])){
			$name = $_GET['search'];
			$products = Product::searchProduct($page, $this->numberItem, $name);
		}
		$numberProduct = Product::numberProductSearch($name);
		$this->renderProduct($products, $page, $numberProduct);
	}

	public function renderProduct($products, $page, $numberProduct){
		// push detail in product
		$numberItem = $this->numberItem;
		$id_category = $_GET['category'] ?? 0;
		$categorys = Category::getAll();
		$colors = Color::getAll();
		$sizes = Size::getAll();

		$nameType = $id_category ? Category::getCategory($id_category)->name : $nameType = 'Tất cả sản phẩm';

		
		foreach($products as $index => $product){
			$details = ProductDetail::getDetail($product->id);

			$colors = [];
			$sizes = [];
			foreach($details as $index => $detail){
				$colors[$index] = $detail->color;
				$sizes[$index] = $detail->size;
			}

			$product['colors'] = array_unique($colors);
			$product['sizes'] = array_unique($sizes);

		}

				
		
		// send page product
		$this->sendPage('product', [
			'categorys' => $categorys,
			'categoryType' => $nameType,
			'products' => $products,
			'colors' => $colors,
			'sizes' => $sizes,
			'numberItem' => $numberItem,
			'page' => $page,
			'numberProduct' => $numberProduct

		]); 
	}

	public function giamgia(){
		return Product::getAllProduct();
	}

	public function getDomain($fil){
		switch($fil){
			case '0':
				return [0, 999999990];
				break;
			case '1':
				return [0, 100000];
				break;
			case '2':
				return [100000, 200000];
				break;
			case '3':
				return [200000, 300000];
				break;
			case '4':
				return [300000, 400000];
				break;
			case '5':
				return [400000, 500000];
				break;
			case '6':
				return [500000, 999999999];
				break;
			default:
		}
	}


}
