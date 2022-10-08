<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Category;
use App\Models\Product;



class CategoryController extends Controller
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
        $categorys = Category::getAll();
        $this->sendPage('admin/category', [
            "categorys" => $categorys
		]); 
	}

    public function add(){
        $category = $_POST['name'];
        if(Category::create(['name' => $category])){
            $messages = ['success' => 'Thêm mới loại sản phẩm thành công!'];
        }else{
            $messages = ['error' => 'Thêm mới loại sản phẩm thất bại!'];

        }

        redirect('/admin/category', ['messages' => $messages]);
    }

    public function delete(){

        if(isset($_GET['id'])){
            if(!Product::countProductOfCategory($_GET['id'])){
                $id = $_GET['id'];
                if(Category::deleteCategory($id)){
                    $messages = ['success' => 'Xóa loại sản phẩm thành công!'];
                    
                }else{
                    $messages = ['error' => 'Xóa loại sản phẩm thất bại!'];
    
                }
            }else{
                $messages = ['error' => 'Không thể xóa loại sản phẩm vì mã này đã được sử dụng!'];
            }
        }else{
            $messages = ['error' => 'Xóa loại sản phẩm thất bại!'];

        }
        redirect('/admin/category', ['messages' => $messages]);
    }

    public function update(){

        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $data = ["name" => $_POST['name']];
            if(Category::updateCategory($id, $data)){
                $messages = ['success' => 'Cập nhật sản phẩm thành công!'];

            }else{
                $messages = ['error' => 'Cập nhật sản phẩm thất bại!'];

            }
        }else{
            $messages = ['error' => 'Cập nhật sản phẩm thất bại!'];

        }
        redirect('/admin/category', ['messages' => $messages]);
    }


}
