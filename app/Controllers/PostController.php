<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\Star;


use App\Controllers\Controller;
use App\SessionGuard as Guard;
class PostController extends Controller
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
		$posts = Post::getAllPost();
		$newPost = $this->post($posts);
		$id_user = $_SESSION['user_id'];

		$stars = Star::getUserHasStar();
		$topStars = $this->topStar($stars);
		$this->sendPage('home', [ 
			'posts' =>  $newPost,
			'postLikes' =>  Like::getLikeOfUser($id_user),
			'topStars' => $topStars
		]); 
	}


    public function newPost(){
        $data = $_POST;
		$err = Post::validate($data);
		if(!empty($_FILES["file"]["tmp_name"])){
			$target_dir = "img/post/";
			include 'upload.php';
			$image = basename($_FILES["file"]["name"]);
			if(!$uploadOk){
				$err['img'] = 'Tải ảnh lên không thành công';
			}
		}else{
			$image = '';
		}
		if(empty($err)){
			$this->createPost($data, $image);
			$messages = ['success' => 'Đăng bài thành công!'];
			redirect('/home', ['messages' => $messages]);
		}else{
			redirect('/home', ['errors' => $err]);
		}
    }


	public function addComment(){
		if(isset($_POST['id_post']) && isset($_POST['id_user'])){
			$data = [];
			$data['id_post'] = $_POST['id_post'];
			$data['id_user'] = $_POST['id_user'];
			$data['content'] = $_POST['content'];
			$data['image'] = '';
			$this->createComment($data);
			redirect('/login');
		}else{
			$err = [];
			$err['comment'] = 'Bình luận không thành công!';
			redirect('/home', ['errors' => $err]);
		}

	}

	public function likePost(){
		if(isset($_POST['id_post']) && isset($_POST['id_user'])){
			$id_post = $_POST['id_post'];
			$id_user = $_POST['id_user'];
			if(!Like::check($id_post, $id_user)){
				$this->createLike($id_post, $id_user);
			}
		}
	}

	public function unlikePost(){
		if(isset($_POST['id_post']) && isset($_POST['id_user'])){
			$id_post = $_POST['id_post'];
			$id_user = $_POST['id_user'];
			if(Like::check($id_post, $id_user)){
				Like::unlike($id_post, $id_user);
			}
		}
	}

	public function star(){
		if(isset($_POST['id_post']) && isset($_POST['id_user'])){
			$id_post = $_POST['id_post'];
			$id_assessor = $_POST['id_user'];
			$id_user = $_POST['id_assessor'];
			$id_comment = $_POST['id_comment'];
			if(!Star::check($id_post, $id_user, $id_assessor, $id_comment)){
				$this->createStar($id_post, $id_user, $id_assessor, $id_comment);
			}
		}
	}

	public function unstar(){
		Star::unStar($id_post, $id_user, $id_assessor);
		if(isset($_POST['id_post']) && isset($_POST['id_user'])){
			$id_post = $_POST['id_post'];
			$id_user = $_POST['id_user'];
			$id_assessor = Post::find($id_post)['id_user'];
			if(Star::check($id_post, $id_user, $id_assessor)){
				Star::unStar($id_post, $id_user, $id_assessor);
			}
		}
	}

	protected function createStar($id_post, $id_user, $id_assessor, $id_comment)
	{
		return Star::create([
			'id_post' => $id_post,
			'id_user' => $id_user,
			'id_assessor' => $id_assessor,
			'id_comment' => $id_comment
		]);
	}

	protected function createLike($id_post, $id_user)
	{
		return Like::create([
			'id_post' => $id_post,
			'id_user' => $id_user
		]);
	}
	
	
	
	protected function createPost($data, $image)
	{
		return Post::create([
			'content' => $data['content'],
			'image' => $image,
			'id_user' => $data['id_user']
		]);
	}

	

	protected function createComment($data){
		return Comment::create([
			'content' => $data['content'],
			'image' => $data['image'],
			'id_user' => $data['id_user'],
			'id_post' => $data['id_post']
		]);
	}

}
