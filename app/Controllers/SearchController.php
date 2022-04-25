<?php

namespace App\Controllers;

use App\SessionGuard as Guard;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\Star;

class SearchController extends Controller
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
        if(isset($_POST['search']) && $_POST['search'] != ''){
            $value = $_POST['search'];
            $posts = Post::searchPost($value);
            $newPost = $this->post($posts);
            $id_user = $_SESSION['user_id'];

            $stars = Star::getUserHasStar();
            $topStars = $this->topStar($stars);
            $this->sendPage('home', [ 
                'posts' =>  $newPost,
                'postLikes' =>  Like::getLikeOfUser($id_user),
                'topStars' => $topStars
            ]);
        }else{
			redirect('/home');
        }
	}
    
}
