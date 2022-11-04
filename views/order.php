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

?>

<?php $this->start("page")?>
<style>
    .order-item {
        background-color: #ebe1e1;
        padding: 20px;
    }
    .order-item__content {
        background-color: #fff;
    }
    .order-item p {
        margin: 0;
    }
    .order-item .btn-vote {
        width: 120px;
    }
    .order-nav {
        /* background-color: #6c6464 !important; */
    }
    .order-nav a {
        color: #333 !important;
    }
    .order-nav a.active{
        color: #333 !important;
        border: 2px solid red;
        background-color: #eae8d7 !important;
    }
    .order-nav a:hover {
        cursor: pointer;
        color: #333 !important;
        background-color: #eae8d7 !important;
        border-bottom: 2px solid red;
    }
</style>
<div id="container">
    <div class="container pt-md-4">
       <div class="row bg-light p-3">
           
            <h3 class="fs-3 p-3 border-bottom">ĐƠN HÀNG ĐÃ MUA</h3>
            <nav class="d-flex justify-content-center order-nav my-3 py-1">
                <a href="/showOrder?act=all" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='all') echo "active"; ?>">Tất cả</a>
                <a href="/showOrder?act=confirm" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='confirm') echo "active"; ?>">Chờ xác nhận</a>
                <a href="/showOrder?act=transport" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='transport') echo "active"; ?>">Đang giao</a>
                <a href="/showOrder?act=rating" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='rating') echo "active"; ?>">Đánh giá</a>
            </nav>
            <div class="list-order">
                <?php
                    foreach($orders as $order){
                        $details = $order['detail'];
                        echo
                        '
                        <div class="order-item mb-4 rounded-3">
                            <div class="order-item__head d-flex justify-content-between">
                            <h6>Mã đơn hàng: '.$order->id.'</h6>
                            <div class="head__transport mb-3">
                        ';
                                
                        if($order->state == 0){
                            echo '<i class="fa-solid fa-truck text-secondary"></i>
                                <span class="text-secondary fs-5">Chờ xác nhận đơn hàng</span>';
                        }
                        if($order->state == 1){
                            echo '<i class="fa-solid fa-truck text-warning"></i>
                                <span class="text-warning fs-5">Đã xác nhận đơn hàng</span>';
                        }
                        if($order->state == 2){
                            echo '<i class="fa-solid fa-truck text-danger"></i>
                                <span class="text-danger fs-5">Đã hủy đơn hàng</span>';
                        }
                        if($order->state == 3){
                            echo '<i class="fa-solid fa-truck text-primary"></i>
                                <span class="text-primary fs-5">Đang giao hàng</span>';
                        }
                        if($order->state == 4){
                            echo '<i class="fa-solid fa-truck text-success"></i>
                                <span class="text-success fs-5">Giao hàng thành công</span>';
                        }
                        echo
                        '
                            </div>
                                <div class="d-flex">
                                    <span class="fs-5">Ngày đặt: <span class="text-danger">'.$order->created_at.'</span></span>
                                    <div class="d-flex mx-3" style="height: 30px;">
                                        <div class="vr"></div>
                                    </div>
                                    <span class="fs-5">Ngày giao: <span class="text-danger">'.$order->date_ship.'</span></span>
                                </div>
                            </div>
                            <div class="order-item-list row gx-3 justify-content-start gy-3">
                        ';

                        foreach($details as $detail){
                            echo
                            '
                            <div class="col col-12 col-sm-12 col-md-6 col-xl-6">
                                <div class="order-item__content d-flex ">
                                    <img src="'.$detail->image.'" class="product-img img-fluid" width="200px"></img>
                                    <div class="p-3">
                                        <h5 class="product-name">'.$detail->name.'</h5> 
                                        <div class="d-flex flex-column">
                                            <p class="fs-5 text-dark p-1">Màu sắc: <span class="product-color">'.$detail->color.'</span></p>
                                            <p class="fs-5 text-dark p-1">Size: <span class="product-size">'.$detail->size.'</span</p>
                                            <p class="fs-5 text-dark p-1">Số lượng: <span class="product-quantity">'.$detail->size.'</p></p>
                                            <p class="fs-5 text-dark p-1">Tổng giá: <span class="product-price text-danger">'.adddotstring($detail->total).'đ</span></p>
                                        </div>
                            ';
                            if($order->state == 4) echo '<button type="submit" class="btn btn-primary btn-update " style="margin-left: 140px" data-bs-toggle="modal" data-bs-target="#modal" onclick="return handleModal('.$detail->id_product.')">Đánh giá</button>';
                            echo'
                                    </div>
                                </div>
                            </div>
                            ';
                        }

                        echo
                        '
                            </div>
                            <div class="order-item__footer mt-4 row ">
                                <div class="col-4">
                                    <span class=" fs-5 text-dark">Tổng đơn hàng: <span class="total-price text-danger">'.adddotstring($order->total_price).'đ</span></span>
                                </div>
                                <div class="col-4 d-flex justify-content-center">
                        ';
                                if($order->state == 0){
                                    echo '<a href="/order/cancelOrder?id='.$order->id.'" class=" btn btn-danger" onclick="return checkConfirm()">Hủy đơn hàng</a>';
                                }

                        echo'
                                </div>
                                <div class="col-4">
                                <span class=" fs-5">Địa chỉ giao hàng: <span>'.$order->address.'</span></span>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                ?>

                <?php 
                    if(!count($orders)){
                        echo '<h4 class="text-secondary text-center m-5">Không có đơn hàng nào</h4>';
                    }
                ?>
    
            </div>
        </div>
        <style>
            


            .cross {
                    padding: 10px;
                color: #d6312d;
                cursor: pointer;
                font-size: 23px;
            }

            .cross i{
                
                margin-top: -5px;
                cursor: pointer;
            }







            .comment-box {
                padding: 5px
            }

            .comment-area textarea {
                resize: none;
                border: 1px solid #ff0000
            }

            .form-control:focus {
                color: #495057;
                background-color: #fff;
                border-color: #ffffff;
                outline: 0;
                box-shadow: 0 0 0 1px rgb(255, 0, 0) !important
            }

            .send {
                color: #fff;
                background-color: #ff0000;
                border-color: #ff0000
            }

            .send:hover {
                color: #fff;
                background-color: #f50202;
                border-color: #f50202
            }

        </style>
        
        <div class="modal fade" id="modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="text-end cross" data-bs-dismiss="modal" aria-label="Close"> <i class="fa fa-times mr-2"></i> </div>
                    <div class="card-body text-center"> <img src=" https://i.imgur.com/d2dKtI7.png" height="100" width="100">
                        <div class="comment-box text-center">
                        <h4>ĐÁNH GIÁ SẢN PHẨM</h4>
                        <form action="/order/vote?id=<?= $_SESSION['user_id'] ?>" method="POST">
                            <div class="rating"> 
                                <input type="radio" name="rating" value="5" id="5"><label class="fs-3"  for="5">☆</label> 
                                <input type="radio" name="rating" value="4" id="4"><label class="fs-3"  for="4">☆</label> 
                                <input type="radio" name="rating" value="3" id="3"><label class="fs-3"  for="3">☆</label> 
                                <input type="radio" name="rating" value="2" id="2"><label class="fs-3"  for="2">☆</label> 
                                <input type="radio" name="rating" value="1" id="1"><label class="fs-3"  for="1">☆</label> 
                            </div>
                            <div class="comment-area"> <textarea class="form-control" name="comment" placeholder="Bình luận..." rows="4"></textarea> </div>
                            <input id="id-product" type="hidden" name="id_product" value="">
                            
                            <div class="text-center mt-4"> <button class="btn btn-success send px-5">Gửi đánh giá <i class="fa fa-long-arrow-right ml-1"></i></button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<script>
    function checkConfirm(){
        return confirm('Bạn có chắc muốn hủy đơn hàng!');
    }

    function handleModal(id){
        $('#id-product').val(id);
    }
</script>

<?php $this->stop() ?>