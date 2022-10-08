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

?>


<?php $this->start("page")?>
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

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