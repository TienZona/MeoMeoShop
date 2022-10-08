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


class ProductDetailController extends Controller {
    public function __construct()
	{
		parent::__construct();
	}

    public function index(){
        $id = $_GET['id'] ?? null;

        $product = Product::getProductById($id);
        $details = ProductDetail::getDetail($product->id);

        $listProductSame = Product::getProductSameType($product['id_category'], $product['id']);

        foreach($listProductSame as $index => $item){
			$details = ProductDetail::getDetail($item->id);

			$colors = [];
			$sizes = [];
			foreach($details as $index => $detail){
				$colors[$index] = $detail->color;
				$sizes[$index] = $detail->size;
			}

			$product['colors'] = array_unique($colors);
			$product['sizes'] = array_unique($sizes);

		}

        // get colors

		$colors = Color::getAll();

		// get sizes

		$sizes = Size::getAll();

        $this->sendPage('product_detail', [
            "product" => $product,
            "details" => $details,
            "list" => $listProductSame,
			'colors' => $colors,
			'sizes' => $sizes,
 		]); 
    }
}