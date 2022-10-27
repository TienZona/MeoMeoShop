<?php 
    $this->layout("admin/default", ["title" => 'Quản trị danh mục']);
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<style>
  .form-check {
    height: 20px;
  }
  .form-check input {
    width: 13px;
  }
  input {
      padding: 10px 15px !important;
      border: 1px solid #CFD8DC !important;
      border-radius: 4px !important;
      box-sizing: border-box;
      background-color: #fff !important;
      color: #000 !important;
      font-size: 16px !important;
      letter-spacing: 1px;
      position: relative;
      width: 100%;
  }

  input:focus {
      -moz-box-shadow: none !important;
      -webkit-box-shadow: none !important;
      box-shadow: none !important;
      border: 1px solid #FFA000 !important;
      outline-width: 0;
  }

  .daterangepicker {
  background-color: #fff;
  border-radius: 0 !important;
  align-content: center !important;
  padding: 0 !important;
  }

  /*Weekday Heading*/
  thead tr:nth-child(2) {
  color: #BDBDBD !important;
  }

  tbody tr td {
  padding: 5px 7px !important;
  }

  .month {
  font-size: 16px !important;
  padding-bottom: 10px !important;
  padding-top: 10px !important;
  }

  .start-date, .end-date {
  border-radius: 0px !important;
  }

  .available:hover {
  border-radius: 0px !important;
  }

  .off {
  color: #EEEEEE !important;
  }

  .off:hover {
  background-color: #EEEEEE !important;
  color: #fff !important;
  }

  .drp-buttons {
  display: none !important;
  }
  
  #modal-detail-product .input-box{
    position: relative;
  }

  #modal-detail-product .input-box i {
    position: absolute;
    right: 13px;
    top:15px;
    color:#ced4da;

  }
  .scope-product__header {
    width: 100%;
    display: flex;
    justify-content: space-between;
  }
  .scope-product__header .input-group {
    position: relative;
    width: 250px;
    height: 40px;
  }
  .scope-product__header input {
    position: absolute;
    width: 200px;
    height: 40px;
  }
  .scope-product__header .input-group-append {
    position: absolute !important;
    width: 50px;
    height: 40px;
    right: 0;
  }
  .scope-product__header button {
    height: 40px
  }
  .scope-product__header .select-group {
    position: relative;
    width: 250px;
    height: 40px;
  }
  .scope-product__header select {
    position: absolute;
    width: 200px;
  }
  .scope-content__list {
      max-height: 300px;
      overflow: auto;
  }
  .scope-content__item {
      background-color: #d1e9f5;
      border-radius: 3px;
      box-shadow: 0 1px 1px #ccc;
  }
  #btn-choice-all {
    position: absolute;
    bottom: 16px;
    right: 50%;
  }
  #btn-choose-all {
    position: absolute;
    bottom: 16px;
    right: 16px;
  }
  .product-choice__footer {
    bottom: 0;
    width: 100%;
    height: 50px;
  }
  .user-item__avatar {
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid blue;
    overflow: hidden;
  }
  .user-item__avatar img{
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
  }
</style>
<div id="container" class="container" style="margin: 120px auto 100px">
    <div class="row">
      <div class="col-2 box-menu">
        <h3 class="box-menu__header">Quản lý</h3>
        <ul class="list-group">
          <a class="list-group-item" href="/admin/account">Tài khoản</a>
          <a class="list-group-item" href="/admin/user">Người dùng</a>
          <a class="list-group-item" href="/admin/product">Sản phẩm</a>
          <a class="list-group-item" href="/admin/category">Danh mục</a>
          <a class="list-group-item" href="/admin/order">Đơn hàng</a>
          <a class="list-group-item" href="/admin/statis">Thống kê</a>
          <a class="list-group-item active" href="/admin/voucher">Mã giảm giá</a>
        </ul>
      </div>
      <div class="col-10">
        <div class="admin-content__heading bg-secondary d-flex justify-content-md-around">
          <h3 class="display-7">Quản lý danh mục</h3>
          <button onclick="handleModalAdd()" class="btn btn-add btn-primary float-end m-3 col-2" data-bs-toggle='modal' data-bs-target='#modal-voucher'>Thêm</button>
        </div>
        <table class="table table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Mã Voucher</th>
                    <th>Mệnh giá</th>
                    <th>%/đ</th>
                    <th>Số lượng</th>
                    <th>Phạm vi sản phẩm</th>
                    <th>Phạm vi người mua</th>
                    <th>Bắt đầu</th>
                    <th>Kết thúc</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody class="table-light">
              <?php foreach($vouchers as $index => $voucher): ?>
                <tr>
                  <td><?= $index+1 ?></td>
                  <td><?= $voucher->id_voucher ?></td>
                  <td><?= $voucher->number ?></td>
                  <td><?= $voucher->type ?></td>
                  <td><?= $voucher->quantity ?></td>
                  <td><?= $voucher->scope_product ? 'Tất cả' : 'Giới hạn' ?></td>
                  <td><?= $voucher->scope_customer ? 'Tất cả' : 'Giới hạn' ?></td>
                  <td><?= $voucher->start_date ?></td>
                  <td><?= $voucher->expiry ?></td>
                  <td>
                    <form action='/admin/category/update&id=9' method='post' onsubmit='return handleModalUpdate(9, <?= json_encode($voucher) ?>);'>
                      <button type='submit' class='btn btn-success btn-update' data-bs-toggle='modal' data-bs-target='#modal-voucher'>Sửa</button>
                    </form>
                  </td>
                  <td>
                    <form action='/admin/voucher/delete&id=<?= $voucher->id ?>' method='post' onsubmit='return confirmDelete();'>
                      <button type='submit' class='btn btn-danger btn-delete'>Xóa</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
        <form id="form-voucher" class="form-voucher" action="/admin/voucher/add" method="post" enctype='multipart/form-data'>
          <div id="modal-voucher" class="modal add-modal fade" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" >
                <div class="modal-content">
                  <div class="modal-header modal-update-header d-flex justify-content-center">
                    <h3 id="modal-name" class="modal-title modal-update-title" id="exampleModalLabel">THÊM MÃ GIẢM GIÁ</h3>
                  </div>
                  <div class="modal-body">
                    <div class="form-group mb-4">
                      <div class="row my-3 bg-light p-2">
                        <div class="col-3">
                            <label for="voucher-id" class="col-form-label">Mã Voucher: </label>
                        </div>
                        <div class="col-5">
                            <input type="text" id="voucher-id" name="voucher-id" required class="form-control" placeholder="Nhập mã voucher...">
                        </div>
                        <div class="col-4 py-2">
                            <span id="passwordHelpInline" class="form-text">
                            Mới nhất <span class="text-light px-2 bg-secondary"><?= $newId ?></span>
                            </span>
                        </div>
                      </div>
                      <div class="row my-3 bg-light p-2 justify-content-around">
                          <div class="col-md-4 form-group">
                              <label for="number" class="form-label">Giá Trị Voucher:</label>
                              <input type="number" class="form-control" min="1" max="100" id="number" name="number" style="height: 38px" required>
                          </div>
                          <div class="col-md-4 form-group">
                            <span>Kiểu:</span>
                            <div class="form-check d-flex align-items-center">
                              <input type="radio" class="type-check" id="type-d" name="type" checked value="đ">
                              <label class="m-2" for="type-d">đ</label>
                            </div>
                            <div class="form-check d-flex align-items-center">
                              <input type="radio" class="type-check" id="type-percient" name="type" value="%">
                              <label class="m-2" for="type-percient">%</label>
                            </div>
                          </div>
                          <div class="col-md-4 form-group">
                            <label for="quantity" class="form-label">Số lượng Voucher:</label>
                            <input type="quantity" class="form-control" min="1" max="1000" id="quantity" name="quantity" style="height: 38px" required>
                          </div>
                        </div>
                        <div class="row my-3 bg-light p-2">
                            <label for="daterange" class="col-5 my-2">Thời gian phát hành:</label>
                            <input class="col-6" type="text" id="datetime" name="daterange" value="01/01/2022 - 01/15/2022" readonly />
                        </div>
                        <div class="row my-3 bg-light p-2 justify-content-around">
                          <div class="col-md-5">
                              <label for="scope-product" class="form-label">Phạm Vi Sản Phẩm:</label>
                              <select class="form-select" id="scope-product" name="scope-product" required>
                              <option selected value="1">Tất cả</option>
                              <option value="0">Giới hạn</option>
                              </select>
                              <button id="btn-detail-product" class="btn btn-primary my-3 d-none" data-bs-target="#modal-detail-product" data-bs-toggle="modal" onclick="return false">
                                Chi tiết
                                <i class="fa-solid fa-eye mx-2"></i>
                              </button>
                          </div>
                          <div class="col-md-5">
                              <label for="scope-customer" class="form-label">Phạm Vi Người Mua:</label>
                              <select class="form-select" id="scope-customer" name="scope-customer" required>
                              <option value="1">Tất cả</option>
                              <option value="0">Giới hạn</option>
                              </select>
                              <button id="btn-detail-customer"  class="btn btn-primary my-3 d-none" data-bs-target="#modal-detail-customer" data-bs-toggle="modal" onclick="return false">
                                Chi tiết
                                <i class="fa-solid fa-eye mx-2"></i>
                              </button>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer modal-update-footer">
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
                    <button id="btn-modal" type="submit" class="btn btn-submit-n" onclick="return submitForm()">Thêm</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="modal-detail-product" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <!-- <div class="modal-header">
                  
                </div> -->
                <div class="modal-body" >
                  <div class="row">
                    <div class="col-6">
                        <div class="scope-product__header scope">
                          <div class="input-group mb-3 ">
                            <input type="text" placeholder="Tìm sản phẩm...">
                            <div class="input-group-append px-2"><button class="btn btn-primary"><i class="fas fa-search"></i></button></div>
                          </div>
                          <div class="select-group">
                            <select class="form-select" aria-label="Default select example">
                              <option selected>Tất cả sản phẩm</option>
                              <?php foreach($categorys as $category): ?>
                                <option value="1"><?= $category->name ?></option>
                              <?php endforeach; ?>
                            </select>
                            <div class="input-group-append px-2"><button class="btn btn-primary"><i class="fa-solid fa-filter"></i></button></div>
                          </div>
                        </div>
                        <div class="scope-product__content">
                          <p id="number-product-choice" class="scope-content__num">23 sản phẩm</p>
                          <div id="scope-product__list" class="scope-content__list">
                              
                          </div>
                          <div class="product-choice__footer">
                            <button id="btn-product-choice-all" class="btn btn-success float-end mt-2">Chọn tất cả</button>
                          </div>
                        </div>
                    </div>
                    <div class="col-6">
                      <h4 style="margin-bottom: 24px">Danh sách sản phẩm áp dụng</h4>
                      <p id="number-product-choose" class="scope-content__num">0 sản phẩm</p>
                      <div id="list-product-choose" class="scope-content__list">
                      </div>
                      <div class="product-choice__footer">
                        <button id="btn-choose-all" class="btn btn-danger float-end mt-2">Hủy tất cả</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-submit-n" data-bs-target="#modal-voucher" onclick="return false" data-bs-toggle="modal">Trở về</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade " id="modal-detail-customer" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="row">
                    <div class="col-6">
                        <div class="scope-product__header scope">
                          <div class="input-group mb-3 ">
                            <input type="text" placeholder="Tìm người dùng...">
                            <div class="input-group-append px-2"><button class="btn btn-primary"><i class="fas fa-search"></i></button></div>
                          </div>
                        </div>
                        <div class="scope-product__content">
                          <p id="number-user-choice" class="scope-content__num">23 người dùng</p>
                          <div id="scope-user__list" class="scope-content__list">
                                
                          </div>
                          <div class="product-choice__footer">
                            <button id="btn-user-choice-all" class="btn btn-success btn-choice-all float-end mt-2">Chọn tất cả</button>
                          </div>
                        </div>
                    </div>
                    <div class="col-6">
                      <h4 style="margin-bottom: 24px">Danh sách người dùng áp dụng</h4>
                      <p id="number-user-choose" class="scope-content__num">0 người dùng</p>
                      <div id="list-user-choose" class="scope-content__list">
                      </div>
                      <div class="product-choice__footer">
                        <button id="btn-user-choose-all" class="btn btn-danger float-end mt-2">Hủy tất cả</button>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-submit-n" data-bs-target="#modal-voucher" onclick="return false" data-bs-toggle="modal">Trở về</button>
                </div>
              </div>
            </div>
          </div>
          
        </form>
    </div>
</div>
<script type="text/javascript">
    function submitForm(){
      const id = $("#voucher-id").val();
      if(id && $("#scope-product").val() == '0'){
        $.ajax({
          url: "/admin/voucher/addProduct",
          method: "POST",
          data:  { products: listChoose, id_voucher: id},
          cache: false,
          error: function(xhr ,text){
              alert('Đã có lỗi: ' + text);
          }
        });
      }
      if(id && $("#scope-customer").val() == '0'){
        $.ajax({
          url: "/admin/voucher/addUser",
          method: "POST",
          data:  {users: listUserChoose, id_voucher: id},
          cache: false,
          error: function(xhr ,text){
              alert('Đã có lỗi: ' + text);
          }
        });
      }
      return true;
    }
    // handle form detail product
    var products = (<?=  $products ?>);
    var listChoose = [];

    // goi tat ca xu ly
    function handleAll(){
      renderListProductChoice(products);
      renderListProductChoose(listChoose);
      handleNumberProductChoice();
      handleNumberProductChoose();
    }

    // xu ly chon tat ca san pham
    $('#btn-product-choice-all').click(function(item){
      products.forEach(function(item){
        listChoose.push(item);
      });
      products = [];
      handleAll();
    })
    
    // Xu ly huy chon tat ca san pham
    $('#btn-choose-all').click(function(item){
      listChoose.forEach(function(item){
        products.push(item);
      });
      listChoose = [];
      handleAll();
    })
    // Xu ly hien thi so luong danh sach san pham
    function handleNumberProductChoice(){
      const number = products.length;
      $('#number-product-choice').html(`${number} sản phẩm`);
    }

    // Xu ly hien thi so luong san pham da chon
    function handleNumberProductChoose(){
      const number = listChoose.length;
      $('#number-product-choose').html(`${number} sản phẩm`);
    }

    // Xu ly huy chon san pham
    function handleChooseProduct(){
      $('.btn-choose').each(function(index, item){
        item.onclick = function(){
          products.push(listChoose[index]);
          listChoose = listChoose.filter(function(product){
            return product.id != listChoose[index].id;
          });
          handleAll();
        }
        
      });
    }

    // Xu ly chon san pham
    function handleChoiceProduct(){
      $('.btn-choice').each(function(index, item){
        item.onclick = function(){
          listChoose.push(products[index]);
          products = products.filter(function(product){
            return product.id != products[index].id;
          });
          
          handleAll();
        }
        
      });
    }

    // hien thi danh sach san pham da chon
    renderListProductChoice(products);
    function renderListProductChoice(products){
        const listElement = document.querySelector('#scope-product__list');
        listElement.innerHTML = '';
        const divElement = document.createElement('div');
        
        products.forEach(function(item){
            const inputElement = document.createElement(`input`);
            inputElement.value = item.id;
            inputElement.name = 'product[]';
            divElement.innerHTML +=
            `
            <div class="scope-content__item my-3">
                <div class="item__product row align-items-center justify-content-between mx-lg-3" style="margin-top: -5px;">
                    <div class="product-id col-2 bg-primary d-flex align-items-center" style="width: 80px; height: 40px">
                      <span class="text-light align-items-center">ID: ${item.id}</span>
                    </div>
                    <div class=" d-flex col-8 p-2" width="240px">
                        <img class="product-img my-2" src="${item.image}" alt="" width="60px" height="60px">
                        <div class="product-info d-flex flex-column px-2">
                            <span class="product-name" style="
                                display:inline-block;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 200px;">
                                ${item.name}
                            </span>
                            <span class="product-quantity">SL: ${item.quantity}</span>
                            <span class="product-price">${item.price}đ</span>
                        </div>
                    </div>
                    <button class="col-2 btn btn-success btn-choice">Chọn <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
            `;
            listElement.appendChild(divElement);
        })
        handleChoiceProduct();
    }

    // hien thi danh sach san pham
    renderListProductChoose(listChoose);
    function renderListProductChoose(products){
        const listElement = document.querySelector('#list-product-choose');
        listElement.innerHTML = '';
        products.forEach(function(item){
            listElement.innerHTML +=
            `
            <div class="scope-content__item my-3">
                <div class="item__product row align-items-center justify-content-between mx-lg-3" style="margin-top: -5px;">
                    <div class="product-id col-2 bg-primary d-flex align-items-center" style="width: 80px; height: 40px">
                      <span class="text-light align-items-center">ID: ${item.id}</span>
                      <input class="productId" name="product[]" value="${item.id}" type="hidden">
                    </div>
                    <div class=" d-flex col-8 p-2" width="240px">
                        <img class="product-img my-2" src="${item.image}" alt="" width="60px" height="60px">
                        <div class="product-info d-flex flex-column px-2">
                            <span class="product-name" style="
                                display:inline-block;
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-width: 200px;">
                                ${item.name}
                            </span>
                            <span class="product-quantity">SL: ${item.quantity}</span>
                            <span class="product-price">${item.price}đ</span>
                        </div>
                    </div>
                    <button class="col-2 btn btn-danger btn-choose"><i class="fa-solid fa-arrow-left"></i> Hủy</button>
                </div>
            </div>
            `;
        })
        handleChooseProduct();
    }
  
  // handle modal user
  var users = (<?= json_encode($users) ?>);
  var listUserChoose = [];
  // goi tat ca xu ly
  function handleAllUser(){
      renderListUserChoice(users);
      renderListUserChosen(listUserChoose);
      handleNumberUserChoice();
      handleNumberUserChosen();
    }

    // xu ly chon tat ca san pham
    $('#btn-user-choice-all').click(function(item){
      users.forEach(function(item){
        listUserChoose.push(item);
      });
      users = [];
      handleAllUser();
    })
    
    // Xu ly huy chon tat ca san pham
    $('#btn-user-choose-all').click(function(item){
      listUserChoose.forEach(function(item){
        users.push(item);
      });
      listUserChoose = [];
      handleAllUser();
    })
    // Xu ly hien thi so luong danh sach san pham
    function handleNumberUserChoice(){
      const number = users.length;
      $('#number-user-choice').html(`${number} người dùng`);
    }

    // Xu ly hien thi so luong san pham da chon
    function handleNumberUserChosen(){
      const number = listUserChoose.length;
      $('#number-user-choose').html(`${number} người dùng`);
    }

    // Xu ly huy chon san pham
    function handleChooseUser(){
      $('.btn-user-choose').each(function(index, item){
        item.onclick = function(){
          users.push(listUserChoose[index]);
          listUserChoose = listUserChoose.filter(function(product){
            return product.id != listUserChoose[index].id;
          });
          handleAllUser();
        }
      });
    }

    // Xu ly chon san pham
    function handleChoiceUser(){
      $('.btn-user-choice').each(function(index, item){
        item.onclick = function(){
          listUserChoose.push(users[index]);
          users = users.filter(function(product){
            return product.id != users[index].id;
          });
        
          handleAllUser();
        }
      });
    }

  renderListUserChoice(users);
  function renderListUserChoice(users){
      const listElement = document.querySelector('#scope-user__list');
      listElement.innerHTML = '';
      users.forEach(function(item){
          listElement.innerHTML +=
          `
          <div class="scope-content__item my-3">
            <div class="item__product row align-items-center justify-content-between mx-lg-3" style="margin-top: -5px;">
              <div class="user-item__avatar col-2">
                <img class="product-img " src="${item.avatar}" alt="" width="60px" height="60px">
              </div>
                <div class=" d-flex col-8 p-2 align-items-center" width="240px">
                    <div class="product-id bg-secondary d-flex align-items-center justify-content-center" style="width: 80px; height: 40px">
                      <span class="text-light align-items-center">ID: ${item.id}</span>
                    </div>
                
                    <div class="product-info d-flex flex-column px-2">
                        <span class="user-name" style="
                            display:inline-block;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 200px;">
                            ${item.fullname}
                        </span>
                        <span class="user-email">${item.email}</span>
                    </div>
                </div>
                <button class="col-2 btn btn-success btn-user-choice">Chọn <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
          `;
      })
      handleChoiceUser();
  }
  
  
  renderListUserChosen(listUserChoose);
  function renderListUserChosen(users){
      const listElement = document.querySelector('#list-user-choose');
      listElement.innerHTML = '';
      users.forEach(function(item){
          listElement.innerHTML +=
          `
          <div class="scope-content__item my-3">
            <div class="item__product row align-items-center justify-content-between mx-lg-3" style="margin-top: -5px;">
              <div class="user-item__avatar col-2">
                <img class="product-img " src="${item.avatar}" alt="" width="60px" height="60px">
              </div>
                <div class=" d-flex col-8 p-2 align-items-center" width="240px">
                    <div class="product-id bg-secondary d-flex align-items-center justify-content-center" style="width: 80px; height: 40px">
                      <span class="text-light align-items-center">ID: ${item.id}</span>
                      <input name="user[]" value="${item.id}" type="hidden">
                    </div>
                
                    <div class="product-info d-flex flex-column px-2">
                        <span class="user-name" style="
                            display:inline-block;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 200px;">
                            ${item.fullname}
                        </span>
                        <span class="user-email">${item.email}</span>
                    </div>
                </div>
                <button class="col-2 btn btn-danger btn-user-choose"><i class="fa-solid fa-arrow-left"></i> Hủy</button>
            </div>
          </div>
          `;
      })
      handleChooseUser();
  }


    // handle event change
  $('.type-check').each(function(index, item){
    var input = $('#number');
    item.onclick = () => {
      if(this.value == '%'){
        input.attr({"max" : 100});
        if(input.val() > 100) input.val('1');
      }else{
        input.attr({"max" : 10000000});
        input.attr({"min" : 1000})
      } 
    }
  })

  $(function() {
      $('input[name="daterange"]').daterangepicker({
      "startDate": "2022-01-01",
      "endDate": "2022-02-01",
      opens: 'center',
      locale: {
          format: 'YYYY-MM-DD'
      }
      });
  });
  function handleScopeProduct(){
    if($('#scope-product').val() == '0'){
      $('#btn-detail-product').removeClass('d-none');
    }else{
      $('#btn-detail-product').addClass('d-none');
    }
  }

  function handleScopeCustomer(){
    if($('#scope-customer').val() == '0'){
      $('#btn-detail-customer').removeClass('d-none');
    }else{
      $('#btn-detail-customer').addClass('d-none');
    }
  }
  $('#scope-product').change(() => handleScopeProduct());
  $('#scope-customer').change(() => handleScopeCustomer());


  function confirmDelete(){
    return confirm('Bạn có chắc muốn xóa! ');
  }
  function handleModalAdd(){
    $("#form-voucher").attr("action", `/admin/voucher/add`);
    $("#modal-name")[0].innerHTML = 'THÊM MÃ GIẢM GIÁ';
    $("#btn-modal")[0].innerHTML = 'Thêm';
  }

  function handleModalUpdate(id, data){
    $("#form-voucher").attr("action", `/admin/voucher/update&id=${id}`);
    $("#modal-name")[0].innerHTML = 'CẬP NHẬT MÃ GIẢM GIÁ';
    $("#btn-modal")[0].innerHTML = 'Cập Nhật';
    $("#voucher-id").val(data.id_voucher);
    $("#scope-product").val(data.scope_product);
    $("#scope-customer").val(data.scope_customer);
    $("#number").val(data.number);
    $("#quantity").val(data.quantity);
    $("#type").val(data.type);
    handleScopeProduct();
    handleScopeCustomer();
    $('input[name="daterange"]').daterangepicker({
        "startDate": data.start_date,
        "endDate": data.expiry,
        opens: 'center',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
    listChoose = data.product;
    listUserChoose = data.user;
    handleAll();
    handleAllUser();
    return false;
  }
  $(document).ready(function () {
      $(".form-voucher").validate({
          rules: {
              name: "required"
          },
          messages: {
            name: "Vui lòng nhập tên loại!",
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
    });


  
</script> 
</div>
<?php $this->stop() ?>