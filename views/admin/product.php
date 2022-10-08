<?php 
    $this->layout("admin/default", ["title" => 'Quản trị sản phẩm']);
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
          <a class="list-group-item" href="/admin/user">Người dùng</a>
          <a class="list-group-item active" href="/admin/product">Sản phẩm</a>
          <a class="list-group-item" href="/admin/category">Danh mục</a>
          <a class="list-group-item" href="/admin/order">Đơn hàng</a>
          <a class="list-group-item" href="/admin/statis">Thống kê</a>
        </ul>
      </div>
      <div class="col-10 admin-content">
        <div class="admin-content__heading bg-secondary d-flex justify-content-md-around">
          <h3 class="display-7">Quản lý sản phẩm</h3>
          <button id="btn-add-product" onclick="setDefaultModalAdd()" class="btn btn-add btn-primary float-end m-3 col-2"  data-bs-toggle='modal' data-bs-target='#add-modal'>Thêm</button>
        </div>
        <table id="product-table" class="table table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Mã SP</th>
                    <th>Loại</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Mẫu</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody class="table-light">
            <?php foreach($products as $index => $product): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td width='70'><?= $product['id']?></td>
                    <td><?= $product['id_category']?></td>
                    <td><img width='50' src='<?= $product['image']?>'></img></td>
                    <td><p class='an'><?= $product['name']?></p></td>
                    <td width='250'><p class='an'><?= $product['description']?></p></td>
                    <td><?= $product['price']?></td>
                    <td>
                      <button type='button' onclick='handleModalView(<?= $product["details"] ?>)' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#detail-modal'>Xem</button>
                    </td>
                    <td>
                      <button type='button' onclick='handleModalUpdate(<?= $product["id"]?>,<?= json_encode($product["name"])?>, <?= $product["id_category"]?>,<?= json_encode($product["description"])?>, <?= $product["price"]?>, <?= $product["details"] ?> ,<?= json_encode($product["image"])?>);'  class='btn btn-success btn-update' data-bs-toggle='modal' data-bs-target='#add-modal'>Sửa</button>
                    </td>
                    <td>
                      <form action='/admin/product/delete?id=<?= $product["id"] ?>' method='post' onsubmit='return confirmDelete();'>
                        <button type='submit' class='btn btn-danger btn-delete'>Xóa</button>
                      </form>
                    </td>
                  </tr>
            <?php endforeach; ?>
            <!-- data-bs-toggle='modal' data-bs-target='#add-modal' -->
            <!-- ,\"$description\", \"$price\", $arr, \"$image\" -->
            </tbody>
        </table>
        <div id="add-modal" class="modal add-modal fade" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
            <form id="form-add-product" class="form-product" action="/admin/product/create" method="post" enctype='multipart/form-data'>
              <div class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content">
                  <div class="modal-header modal-update-header d-flex justify-content-center">
                    <h3 class="modal-title modal-update-title" id="exampleModalLabel">Thêm sản phẩm</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body row justify-content-center">
                      <div class="row col">
                        <div class="col col-5">
                          <div class="form-group mb-4 text-center">
                            <h5>Ảnh sản phẩm</h5>
                            <img id="img-show" name="img" width="200px" src="../../img/no-image.png" alt="">
                            <input id="img-file" type="file" name="file" onchange="uploadImg(event)">
                          </div>
                        </div>
                        <div class="col col-7">
                          <div class="form-group mb-4">
                            <label for="name" class="cols-sm-2 control-label"><b>Tên sản phẩm:</b></label>
                            <div class="input-group">
                              <input id="name" type="text" class="form-control" name="name" id="name"  placeholder="Nhập họ và tên"/>
                              <div id="errorMassage" class="text-center"></div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group mb-4 col col-6">
                              <label for="type" class="cols-sm-2 control-label"><b>Loại sản phẩm:</b></label>
                              <select name="type" id="type" class="p-2">
                                <option value="">--Chọn loại SP--</option>
                                  <?php
                                    foreach($categorys as $category){
                                        $id = $category['id'];
                                        $name = $category['name'];
                                      echo "<option value='$id'>$name</option>";
                                    }
                                  ?>
                                </select>
                                <div id="errorMassage" class="text-center"></div>
                            </div>
                            <div class="form-group mb-4 col col-6">
                              <label for="price" class="cols-sm-2 control-label"><b>Giá sản phẩm:</b> </label>
                              <input id="price" type="number" class="form-control" name="price" value="0" min="0"  placeholder="Giá"/>
                              <div id="errorMassage" class="text-center"></div>
                            </div>
                          </div>
                          <div class="form-group mb-4 col col-6">
                              <label for="description" class="cols-sm-2 control-label"><b>Mô tả sản phẩm:</b> </label>
                              <textarea class="p-3" name="description" id="description" cols="46" rows="4"></textarea>
                              <div id="errorMassage" class="text-center"></div>
                            </div>
                        </div>
                      </div>
                      <div class="row col-10">
                        <label for="number" class="cols-sm-2 control-label"><b>Loại sản phẩm </b></label>
                        <table id="table-product-detail" class="table table-bordered table-striped text-center">
                          <thead class="table-dark">
                              <tr>
                                <th width="40">STT</th>
                                <th width="120">Màu sắc</th>
                                <th width="120">Size</th>
                                <th width="120">Số lượng</th>
                                <th width="50">Xóa</th>
                              </tr>
                          </thead>
                          <tbody id="table-detail-body" class="table-primary">
                              <tr>
                                <td class="number-detail">
                                    1
                                </td>
                                <td class="">
                                  <div class="form-group mb-4 col">
                                    <select  name="color[]" class="select-color" >
                                      <?php
                                        foreach($colors as $color){
                                          echo "<option value='$color'>$color</option>";
                                        }

                                      ?>
                                    </select>
                                    <div id="errorMassage" class="text-center"></div>
                                  </div>
                                </td>
                                <td class="">
                                  <div class="form-group mb-4 col">
                                    <select name="size[]" class="select-size">
                                      <?php
                                        foreach($sizes as $size){
                                          echo "<option value='$size'>$size</option>";
                                        }

                                      ?>
                                    </select>
                                    <div id="errorMassage" class="text-center"></div>
                                  </div>
                                </td>
                                <td class="">
                                  <div class="form-group mb-4 col">
                                    <div class="input-group">
                                      <input id="number" type="number" class="form-control" name="number[]" width="100" value="0" min="0" max="9999"  placeholder="Số lượng"/>
                                      <div id="errorMassage" class="text-center"></div>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <button type="button" class="btn-delete-detail btn btn-danger btn-delete">Xóa</button>
                                </td>
                              </tr>
              
                          </tbody>
                        </table>
                        <button id="btn-add-detail" type="button" class=" btn btn-primary col-2  offset-10">Thêm</button>
                      </div>
                
                  </div>
                  <div class="modal-footer modal-update-footer">
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-submit-n btn-modal">Thêm sản phẩm</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id="detail-modal" class="modal add-modal fade" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered p-4" >
              <div class="modal-content">
                <div class="modal-header modal-update-header d-flex justify-content-center">
                  <h3 class="modal-title modal-update-title" id="exampleModalLabel">Mẫu sản phẩm</h3>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row justify-content-center">
                <table id="table-product-detail" class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                          <th width="40">STT</th>
                          <th width="120">Màu sắc</th>
                          <th width="120">Size</th>
                          <th width="120">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody id="table-detail" class="table-primary">

                    </tbody>
                  </table>
                </div>
                <div class="modal-footer modal-update-footer">
                  <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
  const btnAddDetail = $('#btn-add-detail');
  const tbodyDetail = $('#table-detail-body');

  function confirmDelete(){
    return confirm('Bạn có chắc muốn xóa! ');
  }

  function uploadImg(e){
    if(e.target.files[0]){
      $("#img-show").attr("src", URL.createObjectURL(event.target.files[0]));
    }
  }
  function test(){
    alert(1)
    return false;
  }
// , des, cost, arr, img
  function handleModalUpdate(id, name, type, des, cost, arr, img){
    $("#form-add-product").attr("action", `/admin/product/update?id=${id}`);
    $("#img-show").attr("src", `${img}`);
    // $("#img-file").[0].files[0] = img;
    console.log(img)
    $("#name").val(name);
    $("#type").val(type);
    $("#price").val(cost);
    $("#description").val(des);
    handleDetailUpdate(arr);
    $(".modal-title")[0].innerHTML = 'Cập nhật sản phẩm';
    $(".btn-modal")[0].innerHTML = 'Cập nhật';
    return false;
  }

  function handleModalView(arrays){
    const tbody = $("#table-detail");
    tbody[0].innerHTML = '';
    arrays.forEach(function(detail, index){
      const tr = document.createElement('tr');
      tr.innerHTML = 
      `
        <td>${index+1}</td>
        <td>${detail.color}</td>
        <td>${detail.size}</td>
        <td>${detail.number}</td>
      `;
      tbody[0].appendChild(tr);
    })
  }

  function setDefaultModalAdd(){
    $("#form-add-product").attr("action", `/admin/product/create`);
    $("#img-show").attr("src", '../../img/no-image.png');
    $("#name").val('');
    $("#type").val('');
    $("#price").val('');
    $("#description").val('');
    $(".modal-title")[0].innerHTML = 'Thêm sản phẩm';
    $(".btn-modal")[0].innerHTML = 'Thêm sản phẩm';
    tbodyDetail[0].innerHTML =
    `
    <tr>
      <td class="number-detail">
          1
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <select name="color[]" class="select-color">
            <?php
              foreach($colors as $color){
                echo "<option value='$color->color'>$color->color</option>";
              }

            ?>
          </select>
          <div id="errorMassage" class="text-center"></div>
        </div>
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <select name="size[]" class="select-size">
            <?php
              foreach($sizes as $size){
                echo "<option value='$size->size'>$size->size</option>";
              }

            ?>
          </select>
          <div id="errorMassage" class="text-center"></div>
        </div>
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <div class="input-group">
            <input id="number" type="number" class="form-control" name="number[]" width="100" value="0" min="0" max="9999"  placeholder="Số lượng"/>
            <div id="errorMassage" class="text-center"></div>
          </div>
        </div>
      </td>
      <td>
        <button type="button" class="btn-delete-detail btn btn-danger btn-delete">Xóa</button>
      </td>
    </tr>
    `
  }


  $('#image').change( function(event) {
      var tmppath = URL.createObjectURL(event.target.files[0]);
      $("#img").fadeIn("fast").attr('src',tmppath); 
      alert(tmppath)      
  });

  function handleSTTDetail(){
    const elements = $(".number-detail");
    elements.each(function(index, element){
      element.innerHTML = index + 1;
    })
  }
  handleSTTDetail();


  function handleDetail(){
    const btnDeleteDetails = $('.btn-delete-detail');
    for(let btn of btnDeleteDetails){
      btn.onclick = function(){
        if($('.btn-delete-detail').length >= 2){
          const element = btn.parentElement.parentElement;
          element.outerHTML = '';
          handleSTTDetail();
        }else{
          alert('Sản phẩm tối thiểu phải có một loại!');
        }
      }
    }
  }
  handleDetail();
  function handleDetailUpdate(arr){
    tbodyDetail[0].innerHTML = '';
    arr.forEach(function(detail, index){
      const trElement = document.createElement('tr');
      trElement.innerHTML = 
      `
        <td class="number-detail">
            ${index+1}
        </td>
        <td class="">
          <div class="form-group mb-4 col">
            <select name="color[]" class="select-color" >
              <?php
                foreach($colors as $color){
                  echo "<option value='$color->color'>$color->color</option>";
                }
              ?>
            </select>
            <div id="errorMassage" class="text-center"></div>
          </div>
        </td>
        <td class="">
          <div class="form-group mb-4 col">
            <select name="size[]" class="select-size">
            <?php
                foreach($sizes as $size){
                  echo "<option value='$size->size'>$size->size</option>";
                }
              ?>
            </select>
            <div id="errorMassage" class="text-center"></div>
          </div>
        </td>
        <td class="">
          <div class="form-group mb-4 col">
            <div class="input-group">
              <input id="number" type="number" class="form-control" name="number[]" width="100" value="${detail.number}" min="0" max="9999"  placeholder="Số lượng"/>
              <div id="errorMassage" class="text-center"></div>
            </div>
          </div>
        </td>
        <td>
          <button type="button" class=" btn-delete-detail btn btn-danger btn-delete">Xóa</button>
        </td>
      `;
      tbodyDetail[0].appendChild(trElement); 
      handleDetail(); 
      const selectorColor = $('.select-color')[index];
      const selectorSize = $('.select-size')[index];
      selectorColor.value = detail.color;
      selectorSize.value = detail.size;  
    })
  }

  btnAddDetail[0].onclick = function(){
    const numberDetail = $('.number-detail');
    var number =  numberDetail.length + 1;
    const color = "color" + number;
    const size = "size" + number;
    const quantity = "number" + number;
    const trElement = document.createElement('tr');
    trElement.innerHTML = 
    `
      <td class="number-detail">
          ${number}
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <select name="color[]" class="select-color" >
            <?php
              foreach($colors as $color){
                echo "<option value='$color->color'>$color->color</option>";
              }

            ?>
          </select>
          <div id="errorMassage" class="text-center"></div>
        </div>
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <select name="size[]" class="select-size">
            <?php
              foreach($sizes as $size){
                echo "<option value='$size->size'>$size->size</option>";
              }

            ?>
          </select>
          <div id="errorMassage" class="text-center"></div>
        </div>
      </td>
      <td class="">
        <div class="form-group mb-4 col">
          <div class="input-group">
            <input id="number" type="number" class="form-control" name="number[]" width="100" value="0" min="0" max="9999"  placeholder="Số lượng"/>
            <div id="errorMassage" class="text-center"></div>
          </div>
        </div>
      </td>
      <td>
        <button type="button" class=" btn-delete-detail btn btn-danger btn-delete">Xóa</button>
      </td>
    `;
    tbodyDetail[0].appendChild(trElement);
    handleDetail();
  }

  $.validator.setDefaults({
      submitHandler: function () { 
        return true; 
      }
  });
  $(document).ready(function () {
      $("#form-add-product").validate({
          rules: {
              name: "required",
              type: "required",
              price: "required"
          },
          messages: {
            name: "Vui lòng nhập tên loại!",
            type: "Chọn loại sản phẩm!",
            price: "Nhập giá cho sản phẩm!"
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

<?php $this->stop() ?>