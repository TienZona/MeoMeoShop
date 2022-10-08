<?php 
    $this->layout("layouts/default", ["title" => 'Thông tin tài khoản']);
    $user_id = $_SESSION['user_id'];

    // if(!$errors){
    //   print_r($errors);
    //   foreach($err as $errors ){
    //     echo '<script>alert('$err')</script>';
    //   }
    // }
    
?>

<?php $this->start("page")?>

<div id="header" class="container-fruid">
    <nav class="navbar navbar-expand-lg navbar-dark header-navbar">
        <div class="container">
          <a class="navbar-brand d-flex align-items-center" href="/home">
            <img src="../../img/logo_meomeo.png" alt="" width="120px">
            <h4 class="m-0">MEOMEO</h4>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form id="search-form" class="d-flex navbar-search" action="../product/index.php?" method="get">
              <input class="form-control me-2 navbar-search-input" name="search" type="search" placeholder="Tìm sản phẩm" aria-label="Search">
              <button class="btn btn-outline-success navbar-search-btn" type="submit"><i class="icon-search fas fa-search"></i></button>
            </form>
          </div>
          <div class="navbar-list">
            <div class="navbar-item navbar-item--user">
              <i class="fas fa-user"><span class="navbar-item-name">user</span></i>
              <?php
                  if (isset($_SESSION["user"]))
                  {
                      $user = $_SESSION["user"];
                      echo "
                        <div class='user-box'>
                          <div class='user-box__header'>
                            <span>$user</span> <span>|</span> <a href='../login/index.php?act=out'>Đăng xuất</a>
                            <i class='fas fa-times user-box__header-close'></i>
                          </div>
                          <div class='user-box__content'>
                              <a href='../profile/index.php?act=profile' class='user-box__content-item'>
                                <i class='fas fa-user-circle'></i>
                                <span>Tài khoản </span>
                              </a>
                           
                              <a href='../order/index.php?act=order' class='user-box__content-item'>
                                <i class='fas fa-box'></i>
                                <span>Đơn hàng </span>
                              </a>
                          </div>
                        </div>
                      ";
                  }else
                  {
                      echo "
                      <div class='user-box'>
                        <div class='user-box__header'>
                          <a href='../login/index.php?act=log'>Đăng nhập</a> <span>|</span> <a href='../register/index.php?act=reg'>Đăng ký</a>
                          <i class='fas fa-times user-box__header-close'></i>
                        </div>
                        <div class='user-box__content'>
                          <div class='user-box__content-item'>
                            <i class='fas fa-user-circle'></i>
                            <span>Tài khoản </span>
                          </div>
                          <div class='user-box__content-item'>
                            <i class='fas fa-box'></i>
                            <span>Đơn hàng </span>
                          </div>
                        </div>
                      </div>
                    ";
            
                  }
                ?>
                
            </div>
            <div class="navbar-item navbar-item--notify">
              <i class="fas fa-bell"><span class="navbar-item-name">notify</span></i>
              <div class="box-notify" style="width: 400px">
                <div class="box-notify__header text-center p-2 bg-info rounded-top rounded-2">
                  <span class="text-light">Thông báo mới nhận</span>
                </div>
                <div class="box-notify__container p-2" style="max-height: 300px; overflow: auto;">
                <?php
                  if(isset($id_user)){
                    $notifys = getNotifyLimit($id_user, 5);
                    if(empty($notifys)){
                      echo '<p class="text-center">Không có thông báo nào</p>';
                    }
                    foreach($notifys as $notify){
                      extract($notify);
                      echo
                      '
                        <div class="box-notify__item d-flex align-items-center bg-opacity-10 my-2
                      ';
                      if(!$watched) echo 'bg-secondary';
                      echo
                      '
                        " onmouseenter="watch(this)">
                          <input class="notify-id" type="hidden" value="'.$id_notify.'">
                          <img src="https://www.messengerpeople.com/wp-content/uploads/2020/05/icon-400-messenger-notify-faceblue-1-bg-300x300.png" alt="" width="60px" height="60px">
                          <div class="box-notify__item-content d-flex flex-column mx-2">
                            <span class="fw-bold an-1 fs-6">'.$title.'</span>
                            <span class="text-secondary an-2 m-0">'.$content.'</span>
                          </div>
                        </div>
                      ';
                    }
                  }else{
                    echo '<p class="text-center">Không có thông báo nào</p>';
                  }
                ?>
                </div>
                <div class="box-notify__footer text-center p-2">
                  <a href="../order/index.php?act=order" class="text-dark text-decoration-none">Xem tất cả</a>
                </div>
              </div>
              <div class="navbar-item__box navbar-item__box-notify d-none">
                <span class="navbar-item__quantity navbar-item__quantity-notify"></span>
              </div>
            </div>
            <div class="navbar-item navbar-item--bag">
              <i class="fas fa-shopping-bag"><span class="navbar-item-name">cart</span></i>
              <div class='bag-box'>
                  <div id="bag-box__list" class="bag-box__container">
                  <img src="../../img/empty-cart.jpg" alt="" width="320px">
                  </div>
                  <div class="bag-box__footer">
                    <a href="../cart/index.php?act=home&id=<?= $id_user ?>" class="btn btn-danger">Xem vỏ hàng</a>
                  </div>
              </div>
              <div class="navbar-item__box navbar-item__box-bag d-none">
                <span class="navbar-item__quantity navbar-item__quantity-bag"></span>
              </div>
            </div>
          </div>
        </div>
    </nav>
    <ul class="nav nav-tabs navbar-dark header-nav-sub">
      <div class="container navbar-sub">
        <li class="nav-item">
          <a class="nav-link" href="../product/index.php?act=home">Sản phẩm</a>
        </li>
        <?php
          if(isset($_SESSION['rule']) && $_SESSION['rule'] == 'admin'){
            echo '<li class="nav-item">
                    <a class="nav-link" href="../admin/index.php?act=home">Quản trị</a>
                  </li>';
          }

        ?>
      </div>
    </ul>
  </div>

  <script type="text/javascript">
    const id_user = <?= $id_user; ?>;    
      showCart(id_user);
      function showCart(id_user) {
          if (id_user == "") {
              document.getElementById("bag-box__list").innerHTML = '<img src="../../img/empty-cart.jpg" alt="" width="320px">';
              return;
          }
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
              document.getElementById("bag-box__list").innerHTML = this.responseText;
              const number = this.responseText.split('bag-item d-flex justify-content-between align-items-center mb-2').length - 1;
              if(number > 0){
                const element = document.querySelector('.navbar-item__quantity-bag');
                element.innerHTML = number;
                document.querySelector('.navbar-item__box-bag').classList.remove('d-none');
              }else{
                document.querySelector('.navbar-item__box-bag').classList.add('d-none');
              }
            }
          xhttp.open("GET", "../layouts/index.php?getCart="+id_user);
          xhttp.send();
      }

      function deleteItem(id_user, id_product, color, size, quantity){
        $.ajax({
          url: "../layouts/index.php",
          method: "POST",
          data: { id_user: id_user, id_product: id_product, color: color, size: size, quantity: quantity},
          cache: false,
          error: function(xhr ,text){
              alert('Đã có lỗi: ' + text);
          }
        });
        showCart(id_user);
        showItem(id_user);
      }

      handleQuantityNotify();
      function handleQuantityNotify(){
        const elementNotify = document.querySelectorAll('.box-notify__item.bg-secondary');
        const boxQuantity = document.querySelector('.navbar-item__box-notify');
        const notifyQuantity = document.querySelector('.navbar-item__quantity-notify');
        if(elementNotify.length > 0){
          boxQuantity.classList.remove('d-none');
          notifyQuantity.innerHTML = elementNotify.length;
        }else{
          boxQuantity.classList.add('d-none');
          notifyQuantity.innerHTML = 0;
        }
      }

      function watch(element){
        if(element.classList.contains("bg-secondary")){
          element.classList.remove('bg-secondary');
          handleQuantityNotify();
          const elementId = element.querySelector('.notify-id');
          const id = parseInt(elementId.value);
          $.ajax({
            url: "../layouts/index.php",
            method: "POST",
            data:  { id_notify: id},
            cache: false,
            error: function(xhr ,text){
                alert('Đã có lỗi: ' + text);
            }
          });
        }
      } 

      
    
  </script>
<?php $this->stop() ?>