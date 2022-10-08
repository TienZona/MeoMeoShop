<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller {
    public function __construct()
	{
		parent::__construct();
	}

    public function index(){
        $this->sendPage('cart', [

		    ]); 
    }

    public function addCart(){
        $data = $this->filterData($_POST);
        Cart::createCart($data);
    }

    protected function filterData(array $data)
    {
      return [
        'id_user' => $data['id_user'] ?? null,
        'id_product' =>  $data['id_product'] ?? null,
        'color' => $data['color'] ?? null,
        'size' => $data['size'] ?? null,
        'quantity' => $data['quantity'] ?? null
      ];
    }


  public function deleteItem(){
    if(isset($_GET['id'])){
        $data = [
          "id_user" => $_GET['id'],
          "id_product" => $_POST['id_product'],
          "color" => $_POST['color'],
          "size" => $_POST['size'],
          "quantity" => $_POST['quantity']
        ];
        Cart::deleteCart($data);
    }
  }

  public function updateItem(){
    if(isset($_GET['id'])){
        $data = [
          "id_user" => $_GET['id'],
          "id_product" => $_POST['id_product'],
          "color" => $_POST['color'],
          "size" => $_POST['size'],
          "quantity" => $_POST['quantity']
        ];
        Cart::updateCart($data);
    }
  }

}