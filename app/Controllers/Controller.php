<?php

namespace App\Controllers;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\Star;
use League\Plates\Engine;

class Controller
{
	protected $view;

	public function __construct()
	{
		$this->view = new Engine(ROOTDIR . 'views');
	}

	public function sendPage($page, array $data = [])
	{
		exit($this->view->render($page, $data));
	}
	public function sendNotFound() { 
		http_response_code(404); 
		exit($this->view->render('errors/404')); 
	} 

	// Lưu các giá trị của form được cho trong $data vào $_SESSION 
	protected function saveFormValues(array $data, array $except = [])
	{
		$form = [];
		foreach ($data as $key => $value) {
			if (!in_array($key, $except, true)) {
				$form[$key] = $value;
			}
		}
		$_SESSION['form'] = $form;
	}

	protected function getSavedFormValues()
	{
		return session_get_once('form', []);
	}

	protected function post($posts){
		$newPost = [];
		foreach($posts as $post){
			$id = $post['id_user'];
			$id_post = $post['id'];
			$username = User::getUsername($id);
			$avatar = User::getAvatar($id);
			$post['username'] = $username;
			$post['avatar'] = $avatar;
			
			$comments = Comment::getCommentOfPost($id_post);
			$newComments = [];

			$numberLike = Like::numberLike($id_post);
			$post['number_like'] = $numberLike;

			foreach($comments as $comment){
				$comment['username'] = User::getUsername($comment['id_user']);
				$comment['avatar'] = User::getAvatar($comment['id_user']);
				$comment['star'] = Star::numberStarOfUser($comment['id_user']);
				$comment['listStar'] = Star::getStarOfComment($comment['id']);
				array_push($newComments, $comment);
			}
			
 			$post['comments'] = $comments;

			array_push($newPost, $post);
		}
		return $newPost;
	}

	protected function topStar($stars){
		$topStars = [];
		foreach($stars as $star){
			$id = $star['id_user'];
			$number = Star::numberStarOfUser($id);
			$user = User::getUser($id);
			$user['number_star'] = $number;
			array_push($topStars, $user);
		}
		$topStars = $this->sort($topStars);
		return $topStars;
	}

	public function sort($arr){
		$n = count($arr);
		for ( $i = 0; $i < $n; $i++ )
		{
			for ($j = 0; $j < $n; $j++ )
			{
				if ((int)$arr[$i]['number_star'] > (int)$arr[$j]['number_star'])
				{
					$temp = $arr[$i];
					$arr[$i] = $arr[$j];
					$arr[$j] = $temp;
				}
			}
		}
		return $arr;
	}
}
