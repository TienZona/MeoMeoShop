<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\SessionGuard as Guard;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Vote;

use App\Models\Product;
use App\Models\ProductDetail;

use App\Models\Comment;
use App\Models\CommentReply;


class ProductDetailController extends Controller {
    public function __construct()
	{
		parent::__construct();
	}

    public function index(){
        $id = $_GET['id'] ?? null;

        $product = Product::getProductById($id);
        $details = ProductDetail::getDetail($product->id);

        $listProductSame = Product::getProductSameType($product['id_category'], $product['id']);

        foreach($listProductSame as $index => $item){
			$details = ProductDetail::getDetail($item->id);

			$colors = [];
			$sizes = [];
			foreach($details as $index => $detail){
				$colors[$index] = $detail->color;
				$sizes[$index] = $detail->size;
			}

			$item['colors'] = array_unique($colors);
			$item['sizes'] = array_unique($sizes);
		}
		$votes = Vote::getTop5($id);
		$num = Vote::averagedStar($id) ?: 5;
		$quantityVote = Vote::quatityVote($id);
		// comment 
		$comments = Comment::getCommentOfProduct($id);

		foreach($comments as $index => $comment){
			$replys = CommentReply::getReplyComnent($comment->id);
			$comment['replys'] = $replys;
		}
        $this->sendPage('product_detail', [
            "product" => $product,
            "details" => $details,
            "list" => $listProductSame,
			"num" => $num,
			"votes" => $votes,
			"comments" => $comments,
			"quantityVote" => $quantityVote
 		]); 
    }

	public function addComment(){
		$data = [
			'id_user' => $_POST['id_user'],
			'id_product' => $_POST['id_product'],
			'content' => $_POST['content']
		];
		Comment::createComment($data);
	}

	public function addReply(){
		$data = [
			'id_user' => $_POST['id_user'],
			'id_comment' => $_POST['id_comment'],
			'content' => $_POST['content']
		];
		CommentReply::createReply($data);
	}

	public function deleteComment(){
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			CommentReply::deleteReply($id);
			Comment::deleteComment($id);
		}
	}
}