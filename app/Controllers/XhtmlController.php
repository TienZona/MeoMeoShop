<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Color;
use App\Models\Size;
use App\Models\Notify;



class XhtmlController extends Controller {
    public function __construct()
	{
		parent::__construct();
	}

    public function test(){
        echo "123";
    }

    public function getCart(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $carts = Cart::getCartByIdUser($id);
            if(Cart::getCartByIdUserCount($id)){
                foreach($carts as $cart){
                  $product = Product::getProductById($cart->id_product);
                  $total = $cart->quantity * $product->price;
                  $id_product = $cart->id_product;
                  echo 
                  '
                  <div class="bag-item d-flex justify-content-between align-items-center mb-2">
                    <img class="bag-item__img" src="'.$product->image.'" alt="" width="50">
                    <div class="d-flex flex-column align-items-center px-2">
                      <div class="an-1 bag-item__name">'.$product->name.'</div>
                      <div class="bag-item__content">
                        <span class="bag-item__color">'.$cart->color.'</span>
                        x
                        <span class="bag-item__size">'.$cart->size.'</span>
                        x
                        <span class="bag-item__quantity">'.$cart->quantity.'</span>
                      </div>
                    </div>
                    <span class="bag-item__price">'.$product->price.'đ</span>
                    <button id="bag-item__delete" class="bag-item__delete" onclick="deleteItem('.$cart->id_user.', '.$cart->id_product.', \''.$cart->color.'\', \''.$cart->size.'\', '.$cart->quantity.')">X</button>
                  </div>
                  ';
                };
                #'.$id_user.', '.$id_product.', '.$color.', '.$size.', '.$quantity.',
              }else{
                echo
                '
                <div style="display: flex; justify-content: center">
                    <img src="../../img/empty-cart.jpg" alt="" width="300">
                </div>
                ';
              }
    
        }
    }

    public function showNotify(){
        if(isset($_GET['id'])){
            $notifys = Notify::getNotifyPagination($_GET['id'], 5);
            if($notifys->count()){
                foreach($notifys as $notify){
                    echo
                    '
                        <div class="box-notify__item d-flex align-items-center bg-opacity-10 my-2
                    ';
                    if(!$notify->watched) echo 'bg-secondary';
                    echo
                    '
                        " onmouseenter="watch(this)">
                        <input class="notify-id" type="hidden" value="'.$notify->id.'">
                        <img src="https://www.messengerpeople.com/wp-content/uploads/2020/05/icon-400-messenger-notify-faceblue-1-bg-300x300.png" alt="" width="60px" height="60px">
                        <div class="box-notify__item-content d-flex flex-column mx-2">
                            <span class="fw-bold an-1 fs-6">'.$notify->title.'</span>
                            <span class="text-secondary an-2 m-0">'.$notify->content.'</span>
                        </div>
                        </div>
                    ';
                }
            }else{
                echo '<p class="text-center">Không có thông báo nào</p>';
            }
        }
    }

    public function watchNotify(){
        if(isset($_POST['id_notify'])){
            $id = $_POST['id_notify'];
            Notify::watched($id);
        }
    }

    public function showCart(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $carts = Cart::getCartByIdUser($id);
            
            if(Cart::getCartByIdUserCount($id)){
                foreach($carts as $cart){
                    $product = Product::getProductById($cart->id_product);
                    $details = ProductDetail::getAllDetail($product->id);
                    $colors = ProductDetail::getAllColor($cart->id_product);
                    $sizes = ProductDetail::getAllSize($cart->id_product);
                    $colorItem = $cart->color;
                    $sizeItem = $cart->size;
                    echo 
                    '
                    <div class="item my-3 d-flex align-items-center justify-content-between">
                        <img src="'.$product->image.'" class="item__img" alt="" width="80px">
                        <input type="hidden" value="'.$product->id.'" name="id_product[]" id="id_product">
                        <span class="item__name an">'.$product->name.'</span>
                        <div class="item__color">
                            Màu sắc: 
                            <select name="color[]" id="color" height="20px">
                    ';
                        foreach($colors as $color){
                            echo '<option class="item__color" value="'.$color->color.'"';
                            if($color->color == $colorItem) echo "selected";
                            echo '>'.$color->color.'</option>';
                        }
                    echo'
                            </select>
                        </div>
                        <div class="item__size">
                            Size: 
                            <select name="size[]" id="size" height="20px">
                    ';
                        foreach($sizes as $size){
                            echo '<option class="item__size" value="'.$size->size.'"';
                            if($size->size == $sizeItem) echo "selected";
                            echo '>'.$size->size.'</option>';
                        }
                    echo '
                            </select>
                        </div>
                        <div class="item-group d-flex">
                            <span class="item__price">'.$this->adddotstring($product->price).'đ</span>
                            <div class="detail-quantity d-flex " >
                                <button class="detail-quantity__minus fa-solid fa-minus" onclick="changeQuantity(0,this, '.$cart->id_user.','.$cart->id_product.','.$cart->quantity.', \''.$colorItem.'\', \''.$sizeItem.'\')"></button>
                                <input class="detail-quantity__input text-center" value="'.$cart->quantity.'" min="0" max="100" disable onchange="changeQuantity(2,this, '.$cart->id_user.','.$cart->id_product.','.$cart->quantity.', \''.$colorItem.'\', \''.$sizeItem.'\')">
                                <button class="detail-quantity__plus fa-solid fa-plus" onclick="changeQuantity(1,this, '.$cart->id_user.','.$cart->id_product.','.$cart->quantity.', \''.$colorItem.'\', \''.$sizeItem.'\')"></button>
                            </div>
                            <span class="item__total">'.$this->adddotstring($product->price * $cart->quantity).'đ</span>
                            <button class="item__delete btn " onclick="deleteItem('.$cart->id_user.', '.$cart->id_product.', \''.$colorItem.'\', \''.$sizeItem.'\', '.$cart->quantity.')">Xóa</button>
                        </div>
                    </div>
                    ';
                }
            }else{
                echo '
                <div style="display: flex; justify-content: center">
                    <img src="../../img/empty-cart.jpg" alt="" >
                </div>
                ';
            }
        }else{
            echo '
            <div style="display: flex; justify-content: center">
                <img src="../../img/empty-cart.jpg" alt="" >
            </div>
            ';
        }
    }

    public function adddotstring($strNum) {
 
        $len = strlen($strNum);
        $counter = 3;
        $result = "";
        while ($len - $counter >= 0)
        {
            $con = substr($strNum, $len - $counter , 3);
            $result = '.'.$con.$result;
            $counter+= 3;
        }
        $con = substr($strNum, 0 , 3 - ($counter - $len) );
        $result = $con.$result;
        if(substr($result,0,1)=='.'){
            $result=substr($result,1,$len+1);   
        }
        return $result;
    }
}