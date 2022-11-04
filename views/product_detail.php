<?php 
    $this->layout("layouts/default", ["title" => 'Trang chủ']);
?>
<?php
function adddotstring($strNum) {
 
    $len = strlen($strNum);
    $counter = 3;
    $result = "";
    while ($len - $counter >= 0)
    {
        $con = substr($strNum, $len - $counter , 3);
        $result = '.'.$con.$result;
        $counter+= 3;
    }
    $con = substr($strNum, 0 , 3 - ($counter - $len) );
    $result = $con.$result;
    if(substr($result,0,1)=='.'){
        $result=substr($result,1,$len+1);   
    }
    return $result;
}
function renderColorProduct($color){
    switch ($color){
        case 'Xám':
            $name = 'gray'; break;
        case 'Cam':
            $name = 'orange'; break;
        case 'Đen':
            $name = 'black'; break;
        case 'Đỏ':
            $name = 'red'; break;
        case 'Hồng':
            $name = 'pink'; break;
        case 'Trắng':
            $name = 'white'; break;
        case 'Vàng':
            $name = 'yellow'; break;
        case 'Xanh D':
            $name = 'blue'; break;
        case 'Xanh L':
            $name = 'green'; break;
        default: break;
    }
    echo '<input type="button" name="'.$name.'" class="btn '.$name.' m-1"> ';
}

function renderStar($num){
    for($i = 1; $i <= 5; $i++){
        if($i <= $num){
            echo '<span class="detail__rating-item p-1 fa-solid fa-star"></span>';
        }else{
            echo '<span class="detail__rating-item p-1 fa-solid fa-star text-secondary"></span>';
        }

    }
}

function calculate($d1, $d2){
    return round(abs(strtotime($d1) - strtotime($d2))/86400);
}

?>


<?php $this->start("page")?>
<style>
    .rating-info {
        width: 150px;
        height: 80px;
        background-color: #f1eec7;
        border: 2px solid rgb(218, 221, 133);
    }
    .rating-info__box {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .rating-info h3 {
        color: #a9280f;
        font-size: 24px;
    }
    .comment-list {
        padding: 20px 30px;
    }
    .comment-list__item {
        margin-top: 20px;
    }
    .comment-list__item-info {
        display: flex;
        justify-content: space-between;
    }
    .box-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
    }
    .comment-list__item-info .box-info {
        margin-left: 10px;
    }
    .comment-list__item-content {
        height: 30px;
    }
    .comment-list__item-content span {
        color: #333;
    }
    .comment-list__item-info .box-star p {
        margin: 0 10px;
    }
    .comment-list__item-info .report{
        position: relative;
    }
    .comment-list__item-info .box-report {
        position: absolute;
        right: 15px;
        top: 0;
        width: 80px;
        height: 30px;
        border: 1px solid #ccc;
        background-color: #fff;
        box-shadow: 0 0 1px 1px #ccc;
        border-radius: 2px;
        display: flex;
        justify-content: center;
        align-items: center;
        /* display: none; */
    }
    .comment-list__item-info .report:hover i{
        opacity: 0.7;
        cursor: pointer;
    }
    .comment-list__item-info .box-report:hover {
        cursor: pointer;
        opacity: 0.8;
    }
    textarea{  
        /* box-sizing: padding-box; */
        overflow:hidden;
        /* demo only: */
        padding:10px;
        width:250px;
        font-size:14px;
        margin:50px auto;
        display:block;
        border-radius:10px;
        border:6px solid #556677;
    }
    .input-comment {
        border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: groove;
        background-color: #f8f9fa;
        padding: 10px 20px;
        width: 500px !important;
    }
    .btn-comment {
        margin-top: 10px;
        width: 100px;
        height: 40px;
        border-radius: 20px;
    }
    .comment-reply {
        width: 120px;
    }
    .comment-reply:hover {
        cursor: pointer;
    }
    
    .comment-reply-list {
        width: calc(100% - 50px);
        margin-left: 50px;
    }
    .reply-list__item {
        width: 100%;
    }
    .reply-list__item .comment-list__item{
        width: 100%;
    }
</style>
<div id="container">
    <div class="container py-4">
        <div class="row bg-light p-3 rounded-1">
            <div class="col col-4 col-xl-4">
                <div class="detail__img">
                    <img src="<?= $product['image']; ?>" alt="">
                </div>
            </div>
            <div class="col col-8 col-xl-5 text-center">
                <h4 class="detail__name "><?= $product['name']; ?></h4>
                <p class="detail__text">Mã SP: <span class="detail__code"><?= $product['id']; ?></span></p>
                <p class="detail__text">Loại SP: <span class="detail__code"><?= $product['id_category']; ?></span></p>
                <p class="detail__text">Giá: <span class="detail__price"> <?= $product['price']  ?></span></p>
                <div class="detail__rating text-center">
                    <div class="detail__rating-list">
                        <span class="detail__rating-item fa-solid fa-star"></span>
                        <span class="detail__rating-item fa-solid fa-star"></span>
                        <span class="detail__rating-item fa-solid fa-star"></span>
                        <span class="detail__rating-item fa-solid fa-star"></span>
                        <span class="detail__rating-item fa-solid fa-star"></span>
                    </div>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Màu sắc</th>
                        <th scope="col">Size</th>
                        <th scope="col">SL có sẵn</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thêm vào vỏ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($details as $detail){
                                echo'
                                <tr>
                                    <td class="detail__color">'.$detail->color.'</td>
                                    <td class="detail__size">'.$detail->size.'</td>
                                    <td class="detail__number">'.$detail->number.'</td>
                                    <td >
                                    <div class="detail-quantity d-flex">
                                        <button class="detail-quantity__minus fa-solid fa-minus"></button>
                                        <input class="detail-quantity__input text-center" value="0" min="0" max="'.$detail->number.'" disable>
                                        <button class="detail-quantity__plus fa-solid fa-plus"></button>
                                    </div>
                                    </td>
                                    <td><button type="button" class="detail__list-btn ">Mua ngay</button></td>
                                </tr>
                                ';
                            }

                        ?>
                        
                    </tbody>
                    </table>
            </div>
            <div class="col col-12 col-xl-3">
                <h4 class="detail__description text-center">MÔ TẢ SẢN PHẨM</h4>
                <span class="detail__description-content">
                    <?= $product->description; ?>
                </span>
                
            </div>
        </div>
        <div class="row bg-light p-4 rounded-1">
            <h3 class="detail__heading">SẢN PHẨM CÙNG LOẠI</h3>
            <div class="row product-list" >
            <?php foreach($list as $index => $item):?>
                    <div class="product__item col-6 col-sm-6 col-md-4 col-lg-3 col-xg-3">
                        <div class="card product__item-card">
                        <div class="image-container">
                            <div class="first">
                                <div class="d-flex justify-content-between align-items-center"> 
                                <span class="discount">-25%</span> 
                                <span class="wishlist"><i href="#" class="fa-solid fa-heart icon-heart"></i></span> 
                                </div>
                            </div> 
                            <div class="thumbnail-image">
                            <img src="<?= $item->image ?>" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="product-detail-container p-3">
                            <h5 class="product-name an-product-name d-inline-block text-center"><?= $item->name ?></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="rating">
                                    <span class="number-start">5</span>
                                    <input type="radio" class="rating-start" name="rating" value="5" id="5">
                                    <label for="5">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="4" id="4">
                                    <label for="4">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="3" id="3">
                                    <label for="3">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="2" id="2">
                                    <label for="2">☆</label> 
                                    <input type="radio" class="rating-start" name="rating" value="1" id="1">
                                    <label for="1">☆</label>
                                </div>
                                <a href="/detail?id=<?= $item->id ?>" class="btn-card"><i class="fa-solid fa-bag-shopping icon"></i></a href="../../views/product_detail/index.php?act=info&id='.$id_product.'">
                                <div class="d-flex flex-column mb-2"> 
                                    <span class="new-price"><?= adddotstring($item->price) ?>đ</span> 
                                    <!-- <small class="old-price text-right"><del>200.000đ</del></small>  -->
                                    
                                </div>
                            </div>
                            
                            
                            <div class="d-flex justify-content-between pt-1">
                                <div class="color-select d-flex"> 
                                <?php foreach($item['colors'] as $colors) :?>
                                    <?= renderColorProduct($colors) ?>
                                <?php endforeach ?>
                                </div>
                                <div class="d-flex product-size "> 
                                <?php foreach($item['sizes'] as $sizes) :?>
                                    <span class="item-size m-1 btn" type="button"><?= $sizes ?></span> 
                                <?php endforeach ?>
                                     
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row bg-light p-4 rounded-1">
            <h4 class="detail__heading">ĐÁNH GIÁ SẢN PHẨM</h4>
            <div class="row justify-content-center">
                
                <div class="col-12 col-xl-8">
                    <div class="row bg-light p-4 rounded-1 justify-content-center">
                        <div class="rating-info">
                            <div class="rating-info__box">
                                <span class="text-success"><?= $quantityVote ?> lượt đánh giá</span>
                                <h3 class="fs-5 my-0"><?= number_format($num, 1)?> <span class="fs-5">trên</span> 5</h3>
                                <div class="detail__rating-list">
                                    <?php 
                                        renderStar($num);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="px-5">
                            <span class="border p-2 border-info bg-info bg-opacity-25">Đánh giá mới nhất</span>
                        </div>
                        <div class="row comment-list">
                            <?php foreach($votes as $vote): ?>
                                <div class="comment-list__item">
                                <div class="comment-list__item-info">
                                    <div class="col-6 d-flex">
                                        <div class="box-image">
                                            <img src="<?= $vote->avatar ?>" alt="" width="100%" height="100%">
                                        </div>
                                        <div class="box-info ">
                                            <strong class="name">
                                                <?= $vote->fullname ?>
                                            </strong>
                                            <div class="box-star d-flex">
                                                <?php 
                                                    renderStar($vote->star);
                                                ?>
                                                <p><?= $vote->star ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="date">
                                        <span><?= $vote->created_at ?></span>
                                    </div>
                                    <div class="report">
                                        <i class="icon-report fa-solid fa-ellipsis-vertical fs-5"></i>
                                        <div class="box-report d-none">
                                            <a href="#" class="text-danger text-decoration-none">Báo Cáo</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr> -->
                                <div class="comment-list__item-content row">
                                    <p><strong>Bình luận: </strong><?= $vote->comment ?></p>
                                </div>
                            </div>
                            <hr class="bg-dark">
                            <?php endforeach; ?>

                            <?php
                                if(!count($votes))  echo "<span class='text-center'>Không có đánh giá nào</span>"
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-light p-4 rounded-1">
            <h4 class="detail__heading">BÌNH LUẬN SẢN PHẨM</h4>
            <div class="row justify-content-center">
                
                <div class="col-12 col-xl-8">
                    <div class="row bg-light p-4 rounded-1 justify-content-center">
                        <form action="/detail/comment?<?= isset($_SESSION['user_id']) ? 'id_user='.$_SESSION['user_id']  : ""  ?>&id_product=<?= $product->id ?>" method="POST">
                            <div class="d-flex justify-content-between">
                                <div class="box-image">
                                    <img src="./img/itachi_avatar.jpg" alt="" width="100%" height="100%">
                                </div>
                                <input id="input-comment" class="input-comment" name="content"  required  type="text"
                                name="" id="" placeholder="Viết bình luận..."
                                <?= isset($_SESSION['user_id']) ?  '' : "disabled"  ?>
                                
                                >
                                <button class="btn-comment btn-primary" onclick="return comment(<?= isset($_SESSION['user_id']) ? $_SESSION['user_id']  : 0  ?>, <?= $product->id ?>)">Bình luận</button>
                            </div>
                        </form>
                        <div class="px-5 mt-4">
                            <span class=""><?= count($comments) ?> bình luận</span>
                        </div>
                        <div class="row comment-list my-0 py-0">
                            <?php foreach($comments as $comment): ?>
                                <div class="comment-list__item py-2">
                                    <div class="comment-list__item-info">
                                        <div class=" d-flex">
                                            <div class="box-image">
                                                <img src="<?= $comment->avatar ?>" alt="" width="100%" height="100%">
                                            </div>
                                            <div class="box-info mx-3">
                                                <div style="margin-bottom: 8px;">
                                                    <strong class="name">
                                                        <?= $comment->fullname ?>
                                                    </strong>
                                                    <span class="px-2 text-secondary"><?= $comment->created_at ?></span>
                                                </div>
                                                <div class="comment-list__item-content  row">
                                                    <p class=""><?= $comment->content ?></p>
                                                </div>
                                                <div class="comment-reply text-primary d-flex align-items-center">
                                                    <i class="reply-icon mx-2 fa-solid fa-caret-down text-center"></i>
                                                    <span><?= count($comment->replys) ?> Phản hồi</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="report">
                                            <i class="icon-report fa-solid fa-ellipsis-vertical fs-5"></i>
                                            <div class="box-report d-none ">
                                                <?php if(isset($_SESSION['user_id'])): ?>
                                                    <?php if($_SESSION['rule'] == 'admin' || ($_SESSION['user_id'] == $comment->id_user)): ?>
                                                        <span onclick="deleteComment(<?= $comment->id?>)" class="text-danger text-decoration-none">Delete</span>
                                                    <?php else: ?>
                                                        <span  class="text-danger text-decoration-none">Báo Cáo</span>
                                                    <?php endif ?>
                                                <?php else: ?>
                                                    <span  class="text-danger text-decoration-none">Báo Cáo</span>
                                                <?php endif ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-reply-list d-none">
                                        <form action="#" class="">
                                            <input class="input-reply input-comment" type="text" required name="" id="" placeholder="Viết câu trả lời...">
                                            <button class="btn-comment btn-primary" onclick="return reply(<?= isset( $_SESSION['user_id']) ? $_SESSION['user_id']  : 0  ?>, <?= $comment->id ?>, this  )">Trả lời</button>
                                        </form>
                                        <?php foreach($comment->replys as $reply): ?>
                                            <div class="reply-list__item d-flex">
                                                <div class="comment-list__item">
                                                    <div class="comment-list__item-info">
                                                        <div class="d-flex">
                                                            <div class="box-image">
                                                                <img src="<?= $reply->avatar ?>" alt="" width="100%" height="100%">
                                                            </div>
                                                            <div class="box-info mx-3">
                                                                <div style="margin-bottom: 8px;">
                                                                    <strong class="name">
                                                                        <?= $reply->fullname ?>
                                                                    </strong>
                                                                    <span class="px-2 text-secondary"><?= $reply->created_at ?></span>
                                                                </div>
                                                                <div class="comment-list__item-content  row">
                                                                    <p class=""><?= $reply->content ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteComment(id){
        if(id){
            $.ajax({
                url: "/detail/comment/delete",
                method: "POST",
                data:  { id: id},
                cache: false,
                error: function(xhr ,text){
                    alert('Đã có lỗi: ' + text);
                }
            });
            location.reload();
        }
    }

    function comment(id_user, id_product){
        const content = document.querySelector('#input-comment').value;
        if(id_user != 0){
            $.ajax({
                url: "/detail/comment",
                method: "POST",
                data:  { id_user: id_user, id_product: id_product, content: content},
                cache: false,
                error: function(xhr ,text){
                    alert('Đã có lỗi: ' + text);
                }
            });
            location.reload();
           return false;
        }else{
            alert('Vui lòng đăng nhập để bình luận !');
            return false;
        }
    }

    function reply(id_user, id_comment, btn){
        const content = btn.parentElement.querySelector('.input-reply').value;
        if(id_user != 0){
            $.ajax({
                url: "/detail/reply",
                method: "POST",
                data:  { id_user: id_user, id_comment: id_comment, content: content},
                cache: false,
                error: function(xhr ,text){
                    alert('Đã có lỗi: ' + text);
                }
            });
            location.reload();
           return false;
        }else{
            alert('Vui lòng đăng nhập để bình luận !');
            return false;
        }
    }

    $(document).ready(function(){

        const replyList = $(".comment-reply-list");
        $('.comment-reply').each(function(index){
            this.onclick = function(){
                const iconElement = this.querySelector('i');
                if(iconElement.classList.contains('fa-caret-down')){
                    iconElement.classList.remove('fa-caret-down');
                    iconElement.classList.add('fa-caret-up');
                    replyList[index].classList.remove('d-none');
                }else{
                    iconElement.classList.remove('fa-caret-up');
                    iconElement.classList.add('fa-caret-down');
                    replyList[index].classList.add('d-none');
                }
            }
        })


        const iconReports = $('.icon-report');
        iconReports.each(function(item){
            this.onclick = function(e){
                const boxReport = this.parentElement.querySelector('.box-report');
                boxReport.classList.remove('d-none');
                e.stopPropagation()
            }
        })
        $(document).click(function(e){
            $('.report .box-report').not('.d-none').addClass('d-none')
        })
        // handle product item heart
        $('.icon-heart').click(function(e){
            e.target.classList.contains('active') ? e.target.classList.remove('active') : e.target.classList.add('active');
            
        })

        $('.detail-quantity__minus').each(function(index, item){
            item.onclick = function(){
                const number = parseInt($('.detail-quantity__input')[index].value) - 1;
                if(number >= 0){
                    $('.detail-quantity__input')[index].value = number;
                }
            }
        });

        $('.detail-quantity__plus').each(function(index, item){
            item.onclick = function(){
                const number = parseInt($('.detail-quantity__input')[index].value) + 1;
                const max = parseInt($('.detail-quantity__input')[index].max);
                if(number <= max){
                    $('.detail-quantity__input')[index].value = number;
                }else{
                    $('.detail-quantity__input')[index].value = max;
                    
                }
            };
        });
        $(".detail__list-btn").click(function(e){
            const id_user = <?= $_SESSION['user_id'] ?? 0 ?>    
            if(id_user){
                const id_product = <?= $product->id ?? null ?>  
                console.log(id_product)
                const color = this.parentElement.parentElement.querySelector('.detail__color').innerHTML;
                const size = this.parentElement.parentElement.querySelector('.detail__size').innerHTML;
                const quantity = e.target.parentElement.parentElement.querySelector('.detail-quantity__input').value;
                if(quantity == '0'){
                    alert('Vui lòng chọn số lượng!');
                }else{
                    $.ajax({
                        url: "/addCart",
                        method: "POST",
                        data: { id_user: id_user, id_product: id_product, color: color, size: size, quantity: quantity},
                        cache: false,
                        error: function(xhr ,text){
                            alert('Đã có lỗi: ' + text);
                        }
                    });
                    alert('Sản phẩm đã được thêm vào vỏ hàng!');
                    showCart(id_user);
                }
            }else{
                alert('Vui lòng đăng nhập để mua hàng!');
            }
            
        });

    });

</script>

<?php $this->stop() ?>