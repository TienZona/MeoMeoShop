<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Order;
use App\Models\OrderDetail;


class StatisController extends Controller
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
        if(isset($_GET['statis'])){
            $statis = $_GET['statis'];
        }else{
            $statis = "chart";
        }
        $year = $_POST['year'] ?? 2022;
        $totals = [];
        $numberOrders = [];
        $numberProducts = [];
        for($i = 1; $i <= 12; $i++){
            $totals[$i-1] = Order::getTotalOfMonth($year, $i);
            $numberOrders[$i-1] = Order::getNumberOrderOfMonth($year, $i);

            $orders = Order::getNumberOrderSell($year, $i);
            $number = 0;
            foreach($orders as $order){
                $number += OrderDetail::getNumberProductOfOrder($order->id);
            }
            $numberProducts[$i-1] = $number;
        }

        $this->sendPage('admin/statis', [
            "static" => $statis,
            "totals" => $totals,
            "numberOrders" => $numberOrders,
            "numberProducts" => $numberProducts,
            "year" => $_POST['year'] ?? 2022
		]); 
	}
}
