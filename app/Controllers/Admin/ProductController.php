<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
// use App\Controllers\upload;
use App\SessionGuard as Guard;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;


class ProductController extends Controller
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

		$products = Product::getAll();
        $colors = Color::getAll();
        $sizes = Size::getAll();
        $categorys = Category::getAll();
        foreach($products as $index => $product){
			$details = ProductDetail::getDetail($product->id);
            $product['details'] = $details;
		}


        $this->sendPage('admin/product', [
            "products" => $products,
            "colors" => $colors,
            "sizes" => $sizes,
            "categorys" => $categorys
		]); 
	}

    public function addProduct(){
        $product = $this->filterProductData($_POST);
        $messages = [];
        
        include 'upload.php';
        if(!$uploadOk)  $messages = ['error' => 'Không thể tải ảnh sản phẩm lên!'];
        if($product['image'] == null) $product['image'] = '../../img/no-image.png';
        $id = Product::create($product)->id;

        if(isset($id)){
            $this->createDetail($id);
            $messages = ['success' => 'Thêm mới sản phẩm thành công!'];
        }else{
            $messages = ['error' => 'Thêm mới sản phẩm thất bại!'];

        }
        redirect('/admin/product', ['messages' => $messages]);
    }

    public function updateProduct(){
        $product = $this->filterProductData($_POST);
        $messages = [];
        if($product['image'] == null) unset($product['image']);

        if(isset($_GET['id'])){
            if(Product::updateProduct($_GET['id'], $product)){
                include 'upload.php';
                $this->updateDetail($_GET['id']);
                $messages = ['success' => 'Cập nhập sản phẩm thành công!'];
            }else{
                $messages = ['error' => 'Cập nhập sản phẩm thất bại!'];
            }
        }else{
            $messages = ['error' => 'Cập nhập sản phẩm thất bại!'];
        }

        

        redirect('/admin/product', ['messages' => $messages]);
    }

    public function deleteProduct(){
        $messages = [];
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            if(Product::deleteProduct($id)){
                ProductDetail::deleteDetail($id);
                $messages = ['success' => 'Xóa sản phẩm thành công!'];
            }else{
                $messages = ['error' => 'Xóa sản phẩm thất bại!'];

            }
        }else{
            $messages = ['error' => 'Xóa sản phẩm thất bại!'];

        }
        redirect('/admin/product', ['messages' => $messages]);
    }

    protected function filterProductData(array $data)
	{
		return [
			'image' => $_FILES['file']['name'] ? "../../img/". $_FILES['file']['name'] : null,
			'name' => $data['name'] ?? null,
			'description' => $data['description'] ?? null,
			'price' => $data['price'] ?? 0,
			'id_category' => $data['type'] ?? null,
			'delete' => 0
		];
	}

    protected function updateDetail($id){
        $colors = $_POST['color'];
        $sizes = $_POST['size'];
        $number = $_POST['number'];
        ProductDetail::deleteDetail($id);
        foreach($colors as $index => $color){
            $data = ["id_product" => $id,"color" => $color, "size" => $sizes[$index], "number" => $number[$index]];
            ProductDetail::addDetail($data);
        }
    }

    protected function createDetail($id){
        $colors = $_POST['color'];
        $sizes = $_POST['size'];
        $number = $_POST['number'];
        ProductDetail::deleteDetail($id);
        foreach($colors as $index => $color){
            $data = ["id_product" => $id,"color" => $color, "size" => $sizes[$index], "number" => $number[$index]];
            ProductDetail::addDetail($data);
        }
    }

    protected function uploadFile(){
        
    }

}
