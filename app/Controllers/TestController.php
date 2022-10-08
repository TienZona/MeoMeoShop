<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;

use App\Models\Product;

class TestController extends Controller
{
	public function __construct()
	{
		// if (!Guard::isUserLoggedIn()) {
		// 	redirect('/login');
		// }

		parent::__construct();
	}

	public function index()
	{

		$this->sendPage('test', [

		]); 
	}

    public function upload(){
        include 'upload.php';
        if($uploadOk){
            echo 'OK';
        }else{
            echo 'Error';
        }
    }

}
