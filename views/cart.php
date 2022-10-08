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
<div id="container" class="cart-container">
    <div class="container py-4">
        <div class="row bg-light p-4">
        <nav class="navbar d-flex">
            <div>
                <input type="checkbox" id="checkall">
                Tất cả
            </div>
            <div class="nav-group d-flex">
                <span class="list-group__item">Đơn giá</span>
                <span class="list-group__item">Số lượng</span>
                <span class="list-group__item">Số tiền</span>
                <span class="list-group__item">Xóa</span>
            </div>
        </nav>
        <hr class="bg-dark">
        <div id="list-item" class="list-item">

        </div>
        <div class="group-bottom">
            <div class="voucher">

            </div>
            <div class="transport">

            </div>
        </div>
        <hr class="bg-dark my-4">
        <div class="group-buy d-flex justify-content-around">
            <div class="group-buy__cost">
                <span class="text">Tổng thanh toán
                    <b>(
                    <span class="quantity">0</span>
                    sản phẩm ):</b>
                </span>
                <span class="group-price"><span class="price">0</span>đ</span>
            </div>
            <button id="btn-buy" class="btn" data-bs-toggle="modal" data-bs-target="#modal-buy" disabled>Mua Hàng</button>
            <div class="modal fade" id="modal-buy" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <form action="/cart/createOrder?id=<?= $_SESSION['user_id']; ?>" class="form-horizontal" id="form-buy" method="POST" enctype="multipart/form-data">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header buy-modal-header d-flex justify-content-center">
                            <h5 class="modal-title " id="staticBackdropLabel">THÔNG TIN MUA HÀNG</h5>
                        </div>
                        <div class="modal-body">
                            <div class="list-item">
                                <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Màu</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">SL</th>
                                    <th scope="col">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody class="modal-list-item" >
                                    
                                </tbody>
                                </table>
                            </div>
                            
                            <div class="row py-3">
                                <div class="total-buy col ">
                                <p>Phí vận chuyển (<b> 50km </b>):<span class="text-danger"> 50.000đ</span></p>
                                <p>Tổng (<b id="total-quantity"> 4 </b>) sản phẩm: <span class="total-price text-danger">999.000đ</span></p>
                                <hr class="bg-dark">
                                <p >Tổng thanh toán: <span class="total-money text-danger">1.499.000đ</span></p>
                                <input id="total_price" type="hidden" name="total_price">
                                </div>
                                <div class="payment col ">
                                <p class="text-center p-0">Phương thức thanh toán</p>
                                <div class="d-flex flex-column align-items-center" >
                                    <div class="payment-item mb-3 active d-flex justify-content-center align-items-center">
                                    <img src="https://cdn-icons-png.flaticon.com/512/552/552788.png" alt="" width="50px">
                                    <span class="p-2">Tiền mặt</span>
                                    </div>
                                    <div class="payment-item mb-3 payment-item--momo d-flex justify-content-center align-items-center">
                                    <img src="https://business.momo.vn/assets/landingpage/img/931b119cf710fb54746d5be0e258ac89-logo-momo.png" alt="" width="50px">
                                    <span class="p-2">Ví momo</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <h4 class="text-center border-bottom">Thông Tin Đặt Hàng</h4>
                            
                                <div class="p-3">
                                    <div class="mb-3 form-group">
                                        <label for="fullname" class="form-label control-label">Họ và tên:</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" id="fullname"  name="fullname" placeholder="Nguyễn Văn @" >
                                        <div id="errorMassage" class="text-center err-fullname"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="telephone" class="form-label control-label">Số điện thoại: </label>
                                        <div class="input-group">
                                        <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="085555444">
                                        <div id="errorMassage" class="text-center err-username"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="address1" class="form-label control-label">Địa chỉ nhận hàng: </label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Phường Hưng Lợi, Ninh Kiều, Cần Thơ">
                                        <div id="errorMassage" class="text-center err-username"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="address2" class="form-label control-label">Địa chỉ cụ thể: </label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" id="address2" name="address2" placeholder="26A - Hẻm 132 - Đường 3/2 ">
                                        <div id="errorMassage" class="text-center err-username"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <label for="note" class="form-label control-label">Ghi chú: </label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" id="note" id="note" placeholder="Giao hàng cẩn thận">
                                        <div id="errorMassage" class="text-center err-username"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around">
                            <button type="reset" class="btn btn-secondary close" data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                            <button type="submit" class="btn btn-primary" >Mua Ngay</button>

                        </div>
                        </div>
                    
                    </div>

                </form>
                </div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">  
    function test(){
        return true;
    }
    const id_user = <?= $_SESSION['user_id'] ?? 0 ?>;
    showItem(id_user);
    function showItem(id_user) {
        if (id_user == "") {
            document.getElementById("list-item").innerHTML = '<img src="../../img/empty-cart.jpg" alt="" width="500px">';
            return;
        }
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("list-item").innerHTML = this.responseText;
            const items = document.querySelectorAll('.item');
            const checkAll = document.querySelector('#checkall');
            colorChange(items);
            sizeChange(items);

            checkAll.onchange = function(){
                if(this.checked){
                    handleTotalMoney(items, true);
                    handleModal(items);
                    $('#btn-buy').removeAttr('disabled');
                }else{
                    handleTotalMoney(items, false);
                    $('#btn-buy').attr('disabled', 'true');
                }
            }
            handleTotalMoney(items, checkAll.checked);
            handleModal(items);
        }
        xhttp.open("GET", "/showItem?id="+id_user);
        xhttp.send();
      }
    function colorChange(items){
        items.forEach(function(item){
            const select = item.querySelector('#color');
            select.onchange = function(){
               handleModal(items);
            }
        })
    }
    function sizeChange(items){
        items.forEach(function(item){
            const select = item.querySelector('#size');
            select.onchange = function(){
               handleModal(items);
            }
        })
    }
    function handleModal(items){
        const listElement = document.querySelector('.modal-list-item');
        const quantityItem = document.querySelector('#total-quantity');
        const totalPrice = document.querySelector('.total-price');
        const totalMoney = document.querySelector('.total-money');
        
        totalPrice.innerHTML = document.querySelector('.price').innerHTML + 'đ';
        quantityItem.innerHTML = items.length;
        totalMoney.innerHTML = formatNumber(parseInt(document.querySelector('.price').innerHTML.replaceAll('.', '')) + 50000) + 'đ';


        listElement.innerHTML = '';
        items.forEach(function(item){
            const img = item.querySelector('.item__img').src;
            const name = item.querySelector('.item__name').innerHTML;
            const colorElement = item.querySelector('#color').querySelectorAll('option');
            const id_product = item.querySelector('#id_product').value;
            var color;
            colorElement.forEach(function(item){
                if(item.selected)
                    color = item.value;
            });
            var size;
            const sizeElement = item.querySelector('#size').querySelectorAll('option');
            sizeElement.forEach(function(item){
                if(item.selected)
                size = item.value;
            });
            const price = item.querySelector('.item__price').innerHTML;
            const quantity = item.querySelector('.detail-quantity__input').value;
            const stringTotal = item.querySelector('.item__total').innerHTML;
            const totalItem = parseInt(stringTotal.substr( 0, stringTotal.length-1).replaceAll('.', ''));
            listElement.innerHTML +=
            `
            <tr>
                <td><img src="${img}" alt="" class="modal__img" width="40px"><input type="hidden" value="${id_product}" name="id_product[]"></td>
                <td><input type="hidden" value="${name}" name="name[]"><span class="an modal__name">${name}</span></td>
                <td><input type="hidden" value="${color}" name="color[]"><span class="modal__color">${color}</span></td>
                <td><input type="hidden" value="${size}" name="size[]"><span class="modal__size">${size}</span></td>
                <td><input type="hidden" value="${price}" name="price[]"><span class="modal__price text-danger">${price}</span></td>
                <td><input type="hidden" value="${quantity}" name="number[]"><span class="modal__quantity">${quantity}</span></td>
                <td><input type="hidden" value="${totalItem}" name="total[]"><span class="modal__total text-danger">${stringTotal}</span></td>
            </tr>
            `;
        })
    }
    function handleTotalMoney(items, ac){
        const totalMoney = document.querySelector('.price');
        const quantityElement = document.querySelector('.quantity');
        if(ac){
            var totalPrice = 0;
            items.forEach(function(item){
                const totalElement = item.querySelector('.item__total').innerHTML;
                const inputChecked = item.querySelector('.item__input')
                const total = parseInt(totalElement.replaceAll('.', ''));
                totalPrice += total;
            })
            quantityElement.innerHTML = items.length;
            totalMoney.innerHTML = formatNumber(totalPrice);
            document.querySelector('#total_price').value = totalPrice;
        }else{
            quantityElement.innerHTML = 0;
            totalMoney.innerHTML = formatNumber(0);
        }
    }

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    }

    function changeQuantity(action,element ,id_user, id_product, quantity, color, size){
        if(action == 1) quantity++;
        if(action == 2 && element.value>0) quantity = element.value;
        if(action == 0 && quantity > 1) quantity--;
        const data = { id_product: id_product, color: color, size: size, quantity: quantity};
        console.log(data)
        $.ajax({
            url: "/cart/updateQuantity&id="+id_user,
            method: "POST",
            data: data,
            cache: false,
            error: function(xhr ,text){
                alert('Đã có lỗi: ' + text);
            }
        });
        showItem(id_user);
        // showCart(id_user);
        return true;
    }
    function deleteItem(id_user, id_product, color, size, quantity){
        const data = { id_product: id_product, color: color, size: size, quantity: quantity};
        $.ajax({
            url: "/cart/deleteItem&id="+id_user,
            method: "POST",
            data: data,
            cache: false,
            error: function(xhr ,text){
                alert('Đã có lỗi: ' + text);
            }
        });
        showItem(id_user);
        // showCart(id_user);
        return true;
    }

    $.validator.setDefaults({
        submitHandler: function () { return true; }
    });

    $(document).ready(function(){
        $("#form-buy").validate({
            rules: {
                fullname: {required: true, minlength: 2},
                address1: { required: true, minlength: 10 },
                address2: { required: true, minlength: 10 },
                telephone: {
                  required: true,
                  minlength:10,
                  maxlength:10
                }
            },
            messages: {
                fullname: "Bạn chưa nhập vào họ của bạn",
                telephone: "Vui lòng nhập số điện thoại liên lạc",
                address1: "Vui lòng nhập địa chỉ liên lạc",
                address2: "Vui lòng nhập địa chỉ cụ thể"
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("type") === "checkbox"){
                    error.insertAfter(element.siblings("label"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
          });
    })


  </script>
<?php $this->stop() ?>