<?php

namespace App\Controllers;

use App\SessionGuard as Guard;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\Star;

class InforController extends Controller
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
        if(isset($_GET['id']) && $_GET['id'] != ''){
            $id = $_GET['id'];
            $user = User::getUser($id);
            $posts = Post::getPost($id);
            $newPost = $this->post($posts);
            $id_user = $_SESSION['user_id'];
            $numberStar = Star::numberStarOfUser($id_user);
            $this->sendPage('infor', [
                'user' => $user, 
                'posts' =>  $newPost,
                'postLikes' =>  Like::getLikeOfUser($id_user),
                'numberStar' => $numberStar
            ]); 
        }
		
	}
    public function deletePost(){
		if(isset($_GET['id_post'])){
			$id_post = $_GET['id_post'];
			Post::deletePost($id_post);
			$messages = ['success' => 'Xóa bài viết thành công!'];
			redirect('/infor?id='.$_SESSION['user_id'], ['messages' => $messages]);
		}else{
			$err = [];
			$err['delete'] = 'Xóa bài viết không thành công!';
			redirect('/infor?id='.$_SESSION['user_id'], ['messages' => $err]);
		}
    }
}
