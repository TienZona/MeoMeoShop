<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Vote;



class OrderController extends Controller
{
	public function __construct()
	{
		if (!Guard::isUserLoggedIn()) {
			redirect('/login');
		}

		parent::__construct();
	}

	public function index()
	{
        if(isset($_SESSION['user_id'])){
            $actOrder = $_GET['act'] ?? 'all';
            switch($actOrder){
                case 'confirm':
                    $orders = Order::getWaitingByIdUser($_SESSION['user_id']);
                    break;
                case 'transport':
                    $orders = Order::getTransportByIdUser($_SESSION['user_id']);
                    break;
                case 'rating':
                    $orders = Order::getRatingByIdUser($_SESSION['user_id']);
                    break;
                default: 
                    $actOrder = 'all';
                    $orders = Order::getOrderOfUser($_SESSION['user_id']);
            }

            foreach($orders as $index => $order){
                $details = OrderDetail::getOrderDetail($order->id);
                foreach($details as $i => $detail){
                    $details[$i]['image'] = Product::getImage($detail->id_product);
                    $details[$i]['name'] = Product::getName($detail->id_product);
                    
                }

                $orders[$index]['detail'] =  $details;
            }

            $this->sendPage('order', [
                "orders" => $orders,
                "actOrder" => $actOrder
            ]); 
        }else{
            $messages = ['error' => 'Không thể xem lịch sử đơn hàng!!'];
            redirect('/home', ['messages' => $messages]);
        }

        
	}

    public function cancelOrder(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if(Order::cancelOrder($id))
                $messages = ['success' => 'Hủy đơn hàng thành công!!'];
            else
                $messages = ['error' => 'Hủy đơn hàng thất bại!!'];
        }
        redirect('/showOrder', ['messages' => $messages]);
    }

    public function createOrder(){
        $order = $this->filterFormDataOrder($_POST);
        if(isset($_GET['id'])){
            $order['id_user'] = $_GET['id'];
            $id_order = Order::createOrder($order)->id;
            foreach($_POST['color'] as $index => $color){
                $order_detail = [
                    "id_product" => $_POST['id_product'][$index],
                    "color" => $_POST['color'][$index],
                    "size" => $_POST['size'][$index],
                    "quantity" => $_POST['number'][$index],
                    "total" => $_POST['total'][$index],
                    "id_order" => $id_order
                ];
                if(OrderDetail::createOrderDetail($order_detail)){
                    $data = [
                        "id_product" => $_POST['id_product'][$index],
                        "color" => $_POST['color'][$index],
                        "size" => $_POST['size'][$index],
                        "quantity" => $_POST['number'][$index],
                        "id_user" => $_GET['id']
                    ];
                    $messages = ['success' => 'Đặt hàng thành công!!'];
                    Cart::deleteCart($data);
                }
            }

        }else{
            $messages = ['error' => 'Đặt hàng thất bại!!'];
        }
		redirect('/showCart', ['messages' => $messages]);
    }

    public function createVote(){
        $data = $_POST;
        $messages = [];
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            Vote::createVote([
                'star' => $data['rating'],
                'comment' => $data['comment'],
                'id_user' => $id,
                'id_product' => $data['id_product']
            ]);
            $messages = ['success' => 'Cảm ơn bạn vì đã đánh giá sản phẩm!'];
        };
        redirect('/showOrder?act=rating', ['messages' => $messages]);
    }


    protected function filterFormDataOrder(array $data){
        return [
            "name" => $data['fullname'] ?? null,
            "telephone" => $data['telephone'] ?? null,
            "address" => $data['address1'] ?? null,
            "address_detail" => $data['address2'] ??null,
            "note" => $data['note'] ?? null,
            "state" => 0,
            "total_price" => $data['total_price'] ?? 0

        ];
    }
}
