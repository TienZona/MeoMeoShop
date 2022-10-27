<?php 
    $this->layout("admin/default", ["title" => 'Quản trị']);
?>

<?php $this->start("page")?>
<?php
  if(isset($_SESSION['messages'])){
    foreach($_SESSION['messages'] as $message){
      echo "<script>alert('$message')</script>";
    }
    $_SESSION['messages'] = null;
  }
?>
<div id="container" class="container" style="margin: 120px auto 100px">
    <div class="row">
      <div class="col-2 box-menu">
        <h3 class="box-menu__header">Quản lý</h3>
        <ul class="list-group">
          <a class="list-group-item" href="/admin/account">Tài khoản</a>
          <a class="list-group-item active" href="/admin/user">Người dùng</a>
          <a class="list-group-item" href="/admin/product">Sản phẩm</a>
          <a class="list-group-item" href="/admin/category">Danh mục</a>
          <a class="list-group-item active" href="/admin/order">Đơn hàng</a>
          <a class="list-group-item" href="/admin/statis">Thống kê</a>
          <a class="list-group-item" href="/admin/voucher">Mã giảm giá</a>
        </ul>
      </div>
      <div class="col-10">
        <div class="admin-content__heading bg-secondary d-flex justify-content-md-around">
          <h3 class="display-7">Quản lý đơn hàng</h3>
        </div>
        <style>
          .order-nav {
            background-color: #b4daef !important;
          }
          .order-nav a {
            color: #333 !important;
          }
          .order-nav a.active{
            color: red !important;
            background-color: #fff !important;
          }
          .order-nav a:hover {
            cursor: pointer;
            color: red !important;
            background-color: #fff !important;
          }
        </style>
        <div class="bg-light">
          <nav class="d-flex justify-content-start border-bottom order-nav">
            <a href="/admin/order?act=all" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='all') echo "active"; ?>">Tất cả</a>
            <a href="/admin/order?act=confirm" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='confirm') echo "active"; ?>">Xác nhận</a>
            <a href="/admin/order?act=transport" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='transport') echo "active"; ?>">Đang giao</a>
            <a href="/admin/order?act=success" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='success') echo "active"; ?>">Thành công</a>
            <a href="/admin/order?act=cancel" class="text-dark px-4 py-2 text-decoration-none <?php if($actOrder=='cancel') echo "active"; ?>">Đã hủy</a>
          </nav>
          <div class="order-container p-3">
            <div class="order-confirm">
              <?php
              if(!$orders){
                echo
                '
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <img src="https://meetanshi.com/media/catalog/product/cache/ccb305b1061c785de33da9c79e0526ce/m/2/m2-missing-orders-product-image-380x410.png" width="300px"></img>
                  <h4 class="text-center">Chưa có đơn hàng nào!</h4>
                </div>
                ';
              }else{
                echo
                '
                <table class="table table-striped">
                  <thead>
                    <tr>
                ';
                if($actOrder == 'confirm')  
                echo '<th scope="col"> <input type="checkbox" id="check-all"> Tất cả</th>';
                echo
                '
                      <th scope="col">Mã đơn</th>
                      <th scope="col">Khách hàng</th>
                      <th scope="col">Ngày đặt</th>
                      <th scope="col">SĐT</th>
                      <th scope="col">Địa chỉ</th>
                      <th scope="col">Đơn giá</th>
                  ';
                if($actOrder == 'all')
                echo '<th scope="col">Trạng thái</th>';
                echo
                '
                      <th scope="col">Chi tiết</th>
                    </tr>
                  </thead>
                  <tbody class="list-order">
                ';
                foreach($orders as $order){
                  $details = $order->details;
                  $state = $order->state;
                  $arr = json_encode($order->details);
                  $date = substr($order->created_at, 0, 10);
                  $price = $order->total_price;
                  echo
                  "
                  <tr class='order-item'>
                  ";
                  if($actOrder == 'confirm')
                  echo "<td><input type='checkbox' class='check-item' value='$order->id'></td>";
                  echo
                  "
                    <td><span class='id_order'>$order->id</span></td>
                    <td class='text-start'><span class='name'>$order->name</span></td>
                    <td><span class='date_create'>$order->created_at</span></td>
                    <td><span class='telephone'>$order->telephone</span></td>
                    <td><span class='address'>$order->address</span></td>
                    <td><span class='price text-danger'>$order->total_price đ</span></td>
                  ";
                  if($actOrder == 'all'){
                    if($state == 0)  echo "<td><span class='state text-primary'>Chờ xác nhận</span></td>";
                    if($state == 1) echo "<td><span class='state text-info'>Đã xác nhận</span></td>";
                    if($state == 2) echo "<td><span class='state text-danger'>Đã hủy</span></td>"; 
                    if($state == 3) echo "<td><span class='state text-secondary'>Đang giao</span></td>";; 
                    if($state == 4) echo "<td><span class='state text-success'>Thành công</span></td>";; 
                   
                  }
              
                  echo
                  "
                    <td><button onclick='handleModal($arr, \"$order->name\", \"$order->telephone\", \"$order->date_create\", \"$order->total_price\", \"$order->address\", \"$order->address_detail\", \"$order->note\")' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>Xem</button></td>
                  </tr>
                  ";
                }
                echo
                '
                    </tbody>
                  </table>
                ';
              }
              ?>
            
              
              <?php
              if($orders && $actOrder == 'confirm'){
                echo
                '
                <div class="order-footer d-flex justify-content-center">
                  <button class="btn btn-primary m-2" onclick="confirmOrder()">Xác nhận đơn hàng</button>
                  <button class="btn btn-danger m-2 mx-4" onclick="cancelOrder()">Hủy đơn hàng</button>
                </div>
                ';
              }
              ?>
            </div>
            <!-- <div class="order-transport">
              <?php
              if(!$orders){
                echo
                '
                <div class="d-flex flex-column justify-content-center align-items-center">
                  <img src="https://meetanshi.com/media/catalog/product/cache/ccb305b1061c785de33da9c79e0526ce/m/2/m2-missing-orders-product-image-380x410.png" width="300px"></img>
                  <h4 class="text-center">Chưa có đơn hàng nào đang chờ xác nhận!</h4>
                </div>
                ';
              }else{
                echo
                '
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col"> <input type="checkbox" id="check-all"> Tất cả</th>
                      <th scope="col">Mã đơn</th>
                      <th scope="col">Khách hàng</th>
                      <th scope="col">Ngày đặt</th>
                      <th scope="col">SĐT</th>
                      <th scope="col">Địa chỉ</th>
                      <th scope="col">Đơn giá</th>
                      <th scope="col">Chi tiết</th>
                    </tr>
                  </thead>
                  <tbody class="list-order">
                ';
                foreach($orders as $order){
                  $fullname = $order->name;
                  $details = $order->details;
                  $total = $order->total_price;
                  $arr = json_encode($order->details);
                  $date = substr($order->created_at, 0, 10);
                  $price = $order->total_price;
                  echo
                  "
                  <tr class='order-item'>
                    <td><input type='checkbox' class='check-item' value='$order->id_order'></td>
                    <td><span class='id_order'>$order->id_order</span></td>
                    <td><span class='name'>$order->name</span></td>
                    <td><span class='date_create'>$order->date</span></td>
                    <td><span class='telephone'>$order->telephone</span></td>
                    <td><span class='address'>$order->address</span></td>
                    <td><span class='price text-danger'>$order->price đ</span></td>
                    <td><button onclick='handleModal($arr, $order->details, \"$order->name\", \"$order->telephone\", \"$order->created_at\", \"$order->total\", \"$order->address\", \"$order->address_detail\", \"$order->note\")' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>Xem</button></td>
                  </tr>
                  ";
                }
                echo
                '
                    </tbody>
                  </table>
                ';
              }
              ?>
        
              <?php
              if($orders){
                echo
                '
                <div class="order-footer d-flex justify-content-center">
                  <button class="btn btn-primary m-2" onclick="confirmOrder()">Xác nhận đơn hàng</button>
                  <button class="btn btn-danger m-2 mx-4" onclick="cancelOrder()">Hủy đơn hàng</button>
                </div>
                ';
              }
              ?>
            </div> -->
          </div>
         
        </div>
      </div>
    </div>
    <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-info d-flex justify-content-center">
            <h4 class="modal-title text-light" id="exampleModalLabel">Chi tiết đơn hàng</h4>
          </div>
          <div class="modal-body">
            <table id="modal-table" class="table">
              <thead>
                  <tr>
                  <th scope="col">Ảnh</th>
                  <th scope="col">Mã SP</th>
                  <th scope="col">Màu</th>
                  <th scope="col">Size</th>
                  <th scope="col">SL</th>
                  <th scope="col">Tổng</th>
                  </tr>
              </thead>
              <tbody class="modal-list-item">
                  
              </tbody>
            </table>
            <div class="infor-order">
              <div class="infor-order_item p-2 ">
                  <p class="py-1">Phí vận chuyển: <span class="transfer text-danger">50.000đ</span></p>
                  <p class="py-1">Tổng đơn hàng: <span id="total-price" class=" text-danger">190.000đ</span></p>
                  <p class="py-1">Thời gian đặt hàng: <span id="date-create" class=" text-danger">2022-04-12 02:25:06</span></p>
              
              </div>
              <div class="infor-order_item d-flex p-2">
                  <span class=" control-label col-4">Tên Khách hàng:</span>
                  <input id="name" disabled value="Chung Phát Tiên" type="text" class="form-control" name="name" />
              </div>
              <div class="infor-order_item d-flex p-2">
                  <span class=" control-label col-4">Số điện thoại:</span>
                  <input id="telephone" disabled value="09090909" type="text" class="form-control" name="telephone" />
              </div>
              <div class="infor-order_item d-flex p-2">
                  <span class=" control-label col-4">Địa chỉ giao hàng:</span>
                  <input id="address1" disabled value="Phú Tân An Giang" type="text" class="form-control" name="address1" />
              </div>
              <div class="infor-order_item d-flex p-2">
                  <span class=" control-label col-4">Địa chỉ cụ thể:</span>
                  <input id="address2" disabled value="Trọ mười Tam" type="text" class="form-control" name="address2" />
              </div>
              <div class="infor-order_item d-flex p-2">
                  <span class=" control-label col-4">Ghi chú khách hàng:</span>
                  <input id="note" disabled value="Giao hàng cẩn thận" type="text" class="form-control" name="note"/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
  $("#check-all").change(function(e){
    if(this.checked){
      $(".check-item").prop('checked', true);
    }else{
      $(".check-item").prop('checked', false);
    }
  })

  function confirmOrder(){
    const items = document.querySelectorAll('.check-item:checked');
    var arr = [];
    items.forEach(function(item){
      arr.push(parseInt(item.value));
    })
    $.ajax({
      url: "/admin/order/confirmOrder",
      method: "POST",
      data: { id_orders: arr },
      cache: false,
      error: function(xhr ,text){
          alert('Đã có lỗi: ' + text);
      }
    });
    alert("Đã xác nhận " + (items.length) + " đơn hàng !");
    location.reload();
  }
  function cancelOrder(){
    const items = document.querySelectorAll('.check-item:checked');
    var arr = [];
    items.forEach(function(item){
      arr.push(parseInt(item.value));
    })
    $.ajax({
      url: "/admin/order/cancelOrder",
      method: "POST",
      data: { id_orders: arr },
      cache: false,
      error: function(xhr ,text){
          alert('Đã có lỗi: ' + text);
      }
    });
    alert("Đã hủy " + (items.length) + " đơn hàng !");
    location.reload();
  }

  function handleModal(arr, name, telephone, date, total_price, address1, address2,  note){
    const body = $('.modal-list-item')[0];
    body.innerHTML = '';
    arr.forEach(function(item){
      body.innerHTML +=
      `
      <tr>
        <td><img src="${item.image}" alt="" width="60px"></td>
        <td><span>${item.id_product}</span></td>
        <td><span>${item.color}</span></td>
        <td><span>${item.size}</span></td>
        <td><span>${item.quantity}</span></td>
        <td><span class="text-danger">${formatNumber(item.total)}đ</span></td>
      </tr>
      `;
    })
    $("#name").val(name);
    $("#telephone").val(telephone);
    $("#total-price").html(formatNumber(total_price) + 'đ');
    $("#date-create").html(date)
    $("#address1").val(address1);
    $("#address2").val(address2);
    $("#note").val(note);
    return false;
  }
  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }
</script>

<?php $this->stop() ?>