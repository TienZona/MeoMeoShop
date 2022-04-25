<?php 
    $this->layout("layouts/default", ["title" => 'MeoMeo123']);
    $username = $_SESSION['user_name'];
    $avatar = $_SESSION['user_avatar'];
    $user_id = $_SESSION['user_id'];

    function checkLike($id_post, $arrs){
        foreach($arrs as $item){
            if($item['id_post'] == $id_post)
                return true;
        }
        return false;
    }
    function checkStar($id_user, $stars){
        foreach($stars as $item){
            if($item->id_assessor == $id_user)
                return true;
        }
        return false;
    }
?>

<?php $this->start("page")?>
<div class="container-xl py-3">
    <div class="info-header d-flex justify-content-center">
        <div class="box-header col-xl-6 col-sm-6 col-md-6 col-12 ">
            <div class="info-header__avatar">
                <img src="/img/avatar/<?= $user['avatar'] ?>" alt="" class="rounded-circle p-1 bg-primary">
            </div>
            <div class="info-header__info">
                <h3 class="fw-bold"><?= $user['name'] ?></h3>
                <h6 class="fs-3"><?= $numberStar ?> <i class="fa-solid fa-star"></i></h6>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-10 info-content offset-1 bg-light">
            <h4 class="fw-bold text-center mt-3">Bài viết</h4>
            <div class="post-list">
                <?php  foreach($posts as $index => $post) :?>
                <?php 
                    $id_post = $post['id'];
                ?>
                <div class="post-item my-4">
                    <div class="post-item__head d-flex justify-content-between align-items-center">
                        <div class="post-item__head-info d-flex align-items-center">
                            <div class="head-info__img">
                                <img src="img/avatar/<?= $post['avatar'] ?>" alt="">
                            </div>
                            <h5 class="mx-4 my-0 text-primary  fw-bold"><?= $post['username'] ?></h5>
                        </div>
                        <div class="post-item__head-time d-flex align-items-center">
                            <span class="mx-2 my-0">Ngày đăng: <?= substr($post['created_at'],0,10) ?></span>
                            <span class="mx-2 my-0">Vào lúc:  <?= substr($post['created_at'],-8,10) ?> </span>
                        </div>
                        <?php
                        if($user_id == $post['id_user']):
                        ?>
                        <a href="/deletePost?id_post=<?= $post['id'] ?>" class="text-danger mx-2 delete-post float-end text-decoration-none">
                            <i class=" fa-solid fa-trash"></i>
                            Xóa bài viết
                        </a>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="post-item__content">
                        <p class="post-content fs-5 mx-3 fw-bold"><?= $post['content'] ?></p>
                        <?php if($post['image'] != '') : ?>
                        <img class="post-img" src="img/post/<?= $post['image'] ?>" alt="">
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="post-item__interactive">
                        <div id="like"  class="interactive-like active text-dark mx-2">
                            <span class="interactive-like__quantity"><?= $post['number_like'] ?></span>
                            Like
                            <i class="icon-like fs-4 fa-solid fa-thumbs-up 
                            <?php  if(checkLike($post['id'], $postLikes)) echo "text-primary" ?>
                            " 
                            onclick="likePost(this, <?= $id_post ?>, <?= $user_id ?>)"></i>
                        </div>
                    </div>
                    <hr>
                    <div class="post-item__comment">
                        <div class="row justify-content-around" height="30px">
                            <div class="head-info__img col-2">
                                <img src="/img/avatar/<?=$avatar?>" alt="">
                            </div>
                            <div class="col-8 d-flex justify-content-between">
                                <textarea name="content" require class="comment-content px-3 area-content" cols="70" rows="1" placeholder="Nhập bình luận của bạn"></textarea>
                            </div>
                            <button type="submit" class="btn-comment btn btn-primary col-2" 
                                onclick="handleComment(this, <?= $id_post ?>, <?= $user_id ?>)">Bình luận</button>
                        </div>
                        <div id="comment" class="mx-2">
                            <span class="comment__quantity"><?= count($post['comments']) ?></span>
                            Bình luận
                        </div>
                        <p class="comment-see text-center fs-6 mx-2 text-primary">Xem bình luận</p>
                        <div class="comment-list comment-list p-2 d-none bg-light">
                            <?php foreach($post['comments'] as $comment): ?>
                            <div class="comment-item ">
                                <div class="d-flex align-items-center my-2">
                                    <a href="/infor?id=<?= $user_id ?>" class="d-flex text-decoration-none align-items-center">
                                        <div class="head-info__img col-2">
                                            <img src="img/avatar/<?= $comment['avatar'] ?>" alt="">
                                        </div>
                                        <h5 class="fs-5 text-primary px-3 m-0"><?= $comment['username'] ?></h5>
                                    </a>
                                    <div class="vote-item px-3">
                                        <i class="vote-star icon-vote fa-regular fa-star
                                        <?php if(checkStar($user_id, $comment['listStar'])) echo "fa-solid"?> 
                                        "
                                        onclick="starUser(this, <?= $id_post ?>, <?= $comment['id_user'] ?>, <?= $user_id ?>, <?= $comment['id'] ?>)"></i>
                                        <span class="vote-star-quantity"><?= $comment['star'] ?></span>
                                    </div>
                                    <span class="mx-3"><?= $comment['created_at'] ?></span>
                                </div>
                                <div class="mx-5">
                                    <p class="comment-item__content"> <?= $comment['content'] ?></p>
                                </div>
                                <div class="vote-list d-flex mx-5">
                                    <div class="vote-item px-3">
                                        <i class="vote-like icon-vote fa-regular fa-thumbs-up"></i> 
                                        <span class="vote-like-quantity">0</span>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                            
                    </div>
                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    // like bài viết
    function likePost(item, id_post, id_user){
        if(item.classList.contains("text-primary")){
            item.classList.remove('text-primary');
            const numberElement = item.parentElement.querySelector('.interactive-like__quantity');
            const number = parseInt(numberElement.innerHTML) - 1;
            numberElement.innerHTML = number;
            postAjax('/unLikePost', id_post, id_user);

        }else{
            item.classList.add('text-primary');
            const numberElement = item.parentElement.querySelector('.interactive-like__quantity');
            const number = parseInt(numberElement.innerHTML) + 1;
            numberElement.innerHTML = number;
            const data = {
                id_post: id_post,
                id_user: id_user
            }
            postAjax('/likePost', data);
        }
    }

    function postAjax(url, data){
        $.ajax({
            url: url,
            method: "POST",
            data: data,
            cache: false,
            error: function(xhr ,text){
                alert('Đã có lỗi: ' + text);
            }
        });
    }

    function handleComment(item, id_post, id_user){
        const areaText = item.parentElement.querySelector('.comment-content');
        if(areaText.value != ''){
            $.ajax({
                url: '/addComment',
                method: "POST",
                data: {id_post: id_post, id_user: id_user, content: areaText.value},
                cache: false,
                error: function(xhr ,text){
                    alert('Đã có lỗi: ' + text);
                }
            });
            location.reload();
        }else{
            alert('Bạn chưa nhập bình luận!');
        }
        
    }

     // sử lý đăng bài

     $('#file-upload').change( function(event) {
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#image").fadeIn("fast").attr('src',tmppath); 
    });
    $('.area-content').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        if(this.scrollHeight < 20){
            this.setAttribute('style', 'height: auto;overflow-y:hidden;');
        }
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Hiển thị comment bài viết
    $('.comment-see').each(function(index, item){
        item.onclick = function(){
            if(item.innerHTML == 'Xem bình luận'){
                $('.comment-list')[index].classList.remove('d-none');
                item.innerHTML = 'Ẩn bình luận';
            }else{
                $('.comment-list')[index].classList.add('d-none');
                item.innerHTML = 'Xem bình luận';

            }
        }
    })
    

    // like và star cho bình luận

    const iconLike = $('.vote-like');
    const iconStar = $('.vote-star');


    iconLike.each(function(index, item){
        item.onclick = function(){
            if(item.classList.contains("fa-regular")){
                item.classList.remove('fa-regular');
                item.classList.add('fa-solid')
                const numberElement = item.parentElement.querySelector('.vote-like-quantity');
                const number = parseInt(numberElement.innerHTML) + 1;
                numberElement.innerHTML = number;
            }else{
                item.classList.remove('fa-solid')
                item.classList.add('fa-regular');
                const numberElement = item.parentElement.querySelector('.vote-like-quantity');
                const number = parseInt(numberElement.innerHTML) - 1;
                numberElement.innerHTML = number;
            }
        }
    })

    function starUser(item, id_post, id_assessor, id_user, id_comment){
        const data = {
            id_post: id_post,
            id_user: id_user,
            id_assessor: id_assessor,
            id_comment: id_comment
        }
        if(item.classList.contains("fa-solid")){
            item.classList.remove('fa-solid');
            item.classList.add('fa-regular');
            const numberElement = item.parentElement.querySelector('.vote-star-quantity');
            const number = parseInt(numberElement.innerHTML) - 1;
            numberElement.innerHTML = number;
            postAjax('/unstarUser', data);

        }else{
            item.classList.remove('fa-regular');
            item.classList.add('fa-solid');
            const numberElement = item.parentElement.querySelector('.vote-star-quantity');
            const number = parseInt(numberElement.innerHTML) + 1;
            numberElement.innerHTML = number;
            postAjax('/starUser', data);
            
        }
    }
    
</script>
<?php $this->stop() ?>
