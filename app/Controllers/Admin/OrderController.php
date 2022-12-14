<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Notify;





class OrderController extends Controller
{
	public function __construct()
	{
		if (!Guard::isAdminLoggedIn()) {
			redirect('/login');
		}

		parent::__construct();
	}

	public function index()
	{
        if(isset($_GET['act'])){
            $actOrder = $_GET['act'];
            switch($actOrder){
                case 'all':
                    $orders = Order::getAll();
                    $state = 0;
                    break;
                case 'confirm':
                    $orders = Order::getWaiting();
                    $state = 1;
                    break;
                case 'transport':
                    $orders = Order::getTransport();
                    $state = 3;
                    break;
                case 'success':
                    $orders = Order::getSuccess();
                    $state = 4;
                    break;
                case 'cancel':
                    $orders = Order::getCancel();
                    $state = 2;
                    break;
                default:
                $state = 0;
            }
        }else{
            $actOrder = 'all';
            $orders = Order::getAll();
            $state = 0;
        }

        foreach($orders as $index => $order){
            $detail = OrderDetail::getOrderByIdOrder($order->id);
            foreach($detail as $i => $item) {
                $product = Product::getProductById($item->id_product);
                $detail[$i]['image'] = $product->image;
                $detail[$i]['name'] = $product->name;
            }
            $orders[$index]['details'] = $detail;
        }
        $this->sendPage('admin/order', [
            "orders" => $orders,
            "actOrder" => $actOrder,
            "state" => $state
		]); 
	}

    public function confirm(){
        if(isset($_POST['id_orders'])){
            $id_orders = $_POST['id_orders'];
            foreach($id_orders as $id){
                $title = "????n h??ng $id ???? ???????c x??c nh???n";
                $content = "????n h??ng c???a b???n ???? ???????c x??c nh???n vui l??ng ch??? ?????i ????? nh???n h??ng!";
                $id_user = Order::getIdUser($id);
                $notify = [
                    "title" => $title,
                    "content" => $content,
                    "id_user" => $id_user,
                    "watched" => 0
                ];
                Order::confirmOrder($id);
                Notify::createNotify($notify);
            }
        }
    }

    public function cancel(){
        if(isset($_POST['id_orders'])){
            $id_orders = $_POST['id_orders'];
            foreach($id_orders as $id){
                $title = "????n h??ng $id ???? b??? h???y";
                $content = "Xin l???i ????n h??ng c???a b???n kh??ng th??? cung c???p!";
                $id_user = Order::getIdUser($id);
                $notify = [
                    "title" => $title,
                    "content" => $content,
                    "id_user" => $id_user,
                    "watched" => 0
                ];
                Order::cancelOrder($id);
                Notify::createNotify($notify);

            }
        }
    }

}
