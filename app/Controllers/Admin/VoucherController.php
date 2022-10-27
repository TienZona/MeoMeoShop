<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Voucher;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\VoucherProduct;
use App\Models\VoucherUser;



class VoucherController extends Controller
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
        $vouchers = Voucher::getAll();
        $newId = Voucher::getNewId();
        $categorys = Category::getAll();
        $products = Product::getAll();
        $users = User::getAll();

        foreach($vouchers as $index => $voucher){
            $id_product = VoucherProduct::getIdProduct($voucher->id_voucher);
			$product = Product::getProductById($id_product);
            $voucher['product'] = $product;
		}

        foreach($vouchers as $index => $voucher){
            $id_user = VoucherUser::getIdUser($voucher->id_voucher);
			$user = User::getUser($id_user);
            $voucher['user'] = $user;
		}

        $this->sendPage('admin/voucher', [
            'vouchers' => $vouchers,
            'newId' => $newId,
            'categorys' => $categorys,
            'products' => $products,
            'users' => $users
        ]); 
	}

    public function add(){
        $data = $this->filterDataForm($_POST);
        if(!Voucher::checkIdIsExist($data['id_voucher'])){
            if(Voucher::create($data)){
                $messages = ['success' => 'Thêm mới mã sản phẩm thành công!'];
            }else{
                $messages = ['error' => 'Thêm mới mã sản phẩm thất bại!'];
    
            }
        }else{
            $messages = ['error' => 'Mã voucher đã được sử dụng!'];
        }

        redirect('/admin/voucher', ['messages' => $messages]);
    }
    // static function handleDate($data){
    //     $year = substr($data, 6, 4);
    //     $month = substr($data, 3, 2);
    //     $day = substr($data, 0, 2);
    //     return $year . '-' . $month . '-' . $day;
    // }

    static function filterDataForm(array $data){
        return [
            'id_voucher' => $data['voucher-id'],
            'type' => $data['type'],
            'number' => $data['number'],
            'quantity' => $data['quantity'],
            'scope_product' => $data['scope-product'],
            'scope_customer' => $data['scope-customer'],
            'start_date' => substr($_POST['daterange'], 0, 11),
            'expiry' => substr($_POST['daterange'], 13, 11),
            'deleted' => 0
        ];
    }

    public function addProduct(){
        $products =  $_POST['products'];
        $id_voucher = $_POST['id_voucher'];
        if($id_voucher){
            foreach($products as $index => $product){
                VoucherProduct::create([
                    'voucher_id' => $id_voucher,
                    'product_id' => $product['id']
                ]);
            }
        }
    }
    public function addUser(){
        $users = $_POST['users'];
        $id_voucher = $_POST['id_voucher'];
        if($id_voucher){
            foreach($users as $user){
                VoucherUser::create([
                    'voucher_id' => $id_voucher,
                    'user_id' => $user['id']
                ]);
            }
        }
    }


    public function delete(){

        if(isset($_GET['id'])){
            if(Voucher::deleteVoucher($_GET['id'])){
                $messages = ['success' => 'Xóa loại sản phẩm thành công!'];
            }else{
                $messages = ['error' => 'Xóa loại sản phẩm thất bại!'];
            }
        }else{
            $messages = ['error' => 'Xóa loại sản phẩm thất bại!'];

        }
        redirect('/admin/voucher', ['messages' => $messages]);
    }

    public function update(){

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $data = $this->filterDataForm($_POST);
            if(Voucher::updateVoucher($id, $data)){
                $messages = ['success' => 'Cập nhật mã sản phẩm thành công!'];

            }else{
                $messages = ['error' => 'Cập nhật mã sản phẩm thất bại!'];

            }
        }else{
            $messages = ['error' => 'Cập nhật mã sản phẩm thất bại!'];

        }
        redirect('/admin/voucher', ['messages' => $messages]);
    }


}
